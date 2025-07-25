<?php

namespace App\Controllers;

use App\Models\DownloadModel;
use App\Models\KategoriDownloadModel;

class Download extends BaseController
{
    protected $downloadModel;
    protected $kategoriDownloadModel;

    public function __construct()
    {
        $this->downloadModel = new DownloadModel();
        $this->kategoriDownloadModel = new KategoriDownloadModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data['downloads'] = $this->downloadModel->getDownloadWithKategori();
        $data['title'] = 'Daftar Download';
        
        return view('backend/download/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        $data['kategori_download'] = $this->kategoriDownloadModel->findAll();
        $data['title'] = 'Tambah File Download';
        return view('backend/download/create', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        $rules = [
            'judul' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul harus diisi',
                    'min_length' => 'Judul minimal 3 karakter',
                    'max_length' => 'Judul maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Deskripsi harus diisi',
                    'min_length' => 'Deskripsi minimal 10 karakter'
                ]
            ],
            'id_kategori_download' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kategori harus dipilih',
                    'numeric' => 'Kategori tidak valid'
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'max_size' => 'Ukuran file maksimal 10MB',
                    'ext_in' => 'Tipe file tidak diizinkan'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate nama file unik
            $newName = $file->getRandomName();
            
            // Pindahkan file ke folder uploads/download
            $uploadPath = FCPATH . 'uploads/download/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $newName);
            
            $data = [
                'judul' => trim($this->request->getPost('judul')),
                'deskripsi' => trim($this->request->getPost('deskripsi')),
                'id_kategori_download' => $this->request->getPost('id_kategori_download'),
                'nama_file' => $newName,
                'ukuran_file' => $file->getSize(),
                'tipe_file' => $file->getClientExtension(),
                'hits' => 0,
                'download_count' => 0,
                'tanggal_upload' => date('Y-m-d')
            ];

            try {
                $this->downloadModel->insert($data);
                return redirect()->to('/download')->with('success', 'File download berhasil ditambahkan');
            } catch (\Exception $e) {
                // Hapus file jika gagal insert
                if (file_exists($uploadPath . $newName)) {
                    unlink($uploadPath . $newName);
                }
                return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupload file');
        }
    }

    public function edit($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        if ($id === null) {
            return redirect()->to('/download')->with('error', 'ID download tidak ditemukan');
        }

        $data['download'] = $this->downloadModel->find($id);
        if (!$data['download']) {
            return redirect()->to('/download')->with('error', 'File download tidak ditemukan');
        }

        $data['kategori_download'] = $this->kategoriDownloadModel->findAll();
        $data['title'] = 'Edit File Download';
        return view('backend/download/edit', $data);
    }

    public function update($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        if ($id === null) {
            return redirect()->to('/download')->with('error', 'ID download tidak ditemukan');
        }

        $download = $this->downloadModel->find($id);
        if (!$download) {
            return redirect()->to('/download')->with('error', 'File download tidak ditemukan');
        }

        $rules = [
            'judul' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul harus diisi',
                    'min_length' => 'Judul minimal 3 karakter',
                    'max_length' => 'Judul maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Deskripsi harus diisi',
                    'min_length' => 'Deskripsi minimal 10 karakter'
                ]
            ],
            'id_kategori_download' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Kategori harus dipilih',
                    'numeric' => 'Kategori tidak valid'
                ]
            ]
        ];

        // Jika ada file baru diupload
        $file = $this->request->getFile('file');
        if ($file->isValid() && !$file->hasMoved()) {
            $rules['file'] = [
                'rules' => 'max_size[file,10240]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,zip,rar]',
                'errors' => [
                    'max_size' => 'Ukuran file maksimal 10MB',
                    'ext_in' => 'Tipe file tidak diizinkan'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'judul' => trim($this->request->getPost('judul')),
            'deskripsi' => trim($this->request->getPost('deskripsi')),
            'id_kategori_download' => $this->request->getPost('id_kategori_download')
        ];

        // Jika ada file baru
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/download/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $newName);
            
            // Hapus file lama
            $oldFile = $uploadPath . $download['nama_file'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
            
            $data['nama_file'] = $newName;
            $data['ukuran_file'] = $file->getSize();
            $data['tipe_file'] = $file->getClientExtension();
        }

        try {
            $this->downloadModel->update($id, $data);
            return redirect()->to('/download')->with('success', 'File download berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    public function delete($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        if ($id === null) {
            return redirect()->to('/download')->with('error', 'ID download tidak ditemukan');
        }

        $download = $this->downloadModel->find($id);
        if (!$download) {
            return redirect()->to('/download')->with('error', 'File download tidak ditemukan');
        }

        try {
            // Hapus file fisik
            $filePath = FCPATH . 'uploads/download/' . $download['nama_file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Hapus data dari database
            $this->downloadModel->delete($id);
            return redirect()->to('/download')->with('success', 'File download berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/download')->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    public function download($id = null)
    {
        try {
            if ($id === null) {
                return redirect()->back()->with('error', 'ID download tidak ditemukan');
            }

            $download = $this->downloadModel->find($id);
            if (!$download) {
                return redirect()->back()->with('error', 'File download tidak ditemukan');
            }

            $filePath = FCPATH . 'uploads/download/' . $download['nama_file'];
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File tidak ditemukan');
            }

            // Update hit counter
            $this->downloadModel->update($id, ['hits' => $download['hits'] + 1]);

            // Generate safe filename
            $safe_filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $download['judul']);
            $extension = pathinfo($download['nama_file'], PATHINFO_EXTENSION);
            $download_filename = $safe_filename . '.' . $extension;

            // Set content type berdasarkan ekstensi
            $content_type = 'application/octet-stream';
            switch (strtolower($extension)) {
                case 'pdf':
                    $content_type = 'application/pdf';
                    break;
                case 'doc':
                    $content_type = 'application/msword';
                    break;
                case 'docx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    break;
                case 'xls':
                    $content_type = 'application/vnd.ms-excel';
                    break;
                case 'xlsx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    break;
                case 'ppt':
                    $content_type = 'application/vnd.ms-powerpoint';
                    break;
                case 'pptx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                    break;
                case 'zip':
                    $content_type = 'application/zip';
                    break;
                case 'rar':
                    $content_type = 'application/x-rar-compressed';
                    break;
                case 'jpg':
                case 'jpeg':
                    $content_type = 'image/jpeg';
                    break;
                case 'png':
                    $content_type = 'image/png';
                    break;
                case 'gif':
                    $content_type = 'image/gif';
                    break;
            }

            // Clear output buffers
            while (ob_get_level()) {
                ob_end_clean();
            }

            // Set response headers
            $this->response->setContentType($content_type);
            $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $download_filename . '"');
            $this->response->setHeader('Content-Length', (string)filesize($filePath));
            $this->response->setHeader('Cache-Control', 'no-cache, must-revalidate');
            $this->response->setHeader('Pragma', 'no-cache');
            $this->response->setHeader('Expires', '0');

            // Read and output file content
            $file_content = file_get_contents($filePath);
            if ($file_content === false) {
                throw new \Exception('Tidak bisa membaca file');
            }

            $this->response->setBody($file_content);
            return $this->response;
        } catch (\Exception $e) {
            log_message('error', 'Download backend error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'File tidak dapat diunduh');
        }
    }
} 