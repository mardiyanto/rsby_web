<?php

namespace App\Controllers;

use App\Models\GaleriModel;

class Galeri extends BaseController
{
    protected $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Data Galeri',
            'galeri' => $this->galeriModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('backend/galeri/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Galeri',
            'validation' => \Config\Services::validation()
        ];

        return view('backend/galeri/create', $data);
    }

    public function store()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul galeri harus diisi',
                    'min_length' => 'Judul minimal 3 karakter',
                    'max_length' => 'Judul maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 1000 karakter'
                ]
            ],
            'tanggal_upload' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal upload harus diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'uploaded' => 'Pilih file gambar terlebih dahulu',
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'Format file tidak didukung'
                ]
            ]
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file
        $file = $this->request->getFile('gambar');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/galeri', $newName);

            // Simpan data
            $data = [
                'judul' => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'nama_file' => $newName,
                'tanggal_upload' => $this->request->getPost('tanggal_upload')
            ];

            if ($this->galeriModel->insert($data)) {
                return redirect()->to('/galeri')->with('success', 'Galeri berhasil ditambahkan');
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal menambahkan galeri');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal upload file');
        }
    }

    public function edit($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('/galeri')->with('error', 'Galeri tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Galeri',
            'galeri' => $galeri,
            'validation' => \Config\Services::validation()
        ];

        return view('backend/galeri/edit', $data);
    }

    public function update($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('/galeri')->with('error', 'Galeri tidak ditemukan');
        }

        // Validasi input
        $rules = [
            'judul' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Judul galeri harus diisi',
                    'min_length' => 'Judul minimal 3 karakter',
                    'max_length' => 'Judul maksimal 255 karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'Deskripsi maksimal 1000 karakter'
                ]
            ],
            'tanggal_upload' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal upload harus diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ]
        ];

        // Jika ada file baru
        $file = $this->request->getFile('gambar');
        if ($file->isValid() && !$file->hasMoved()) {
            $rules['gambar'] = [
                'rules' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif]',
                'errors' => [
                    'max_size' => 'Ukuran file maksimal 2MB',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'Format file tidak didukung'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file baru jika ada
        $nama_file = $galeri['nama_file'];
        if ($file->isValid() && !$file->hasMoved()) {
            // Hapus file lama
            $old_file = ROOTPATH . 'public/uploads/galeri/' . $galeri['nama_file'];
            if (file_exists($old_file)) {
                unlink($old_file);
            }

            // Upload file baru
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/galeri', $newName);
            $nama_file = $newName;
        }

        // Update data
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'nama_file' => $nama_file,
            'tanggal_upload' => $this->request->getPost('tanggal_upload')
        ];

        if ($this->galeriModel->update($id, $data)) {
            return redirect()->to('/galeri')->with('success', 'Galeri berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui galeri');
        }
    }

    public function delete($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('/galeri')->with('error', 'Galeri tidak ditemukan');
        }

        // Hapus file
        $file_path = ROOTPATH . 'public/uploads/galeri/' . $galeri['nama_file'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if ($this->galeriModel->delete($id)) {
            return redirect()->to('/galeri')->with('success', 'Galeri berhasil dihapus');
        } else {
            return redirect()->to('/galeri')->with('error', 'Gagal menghapus galeri');
        }
    }

    public function download($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $galeri = $this->galeriModel->find($id);
        if (!$galeri) {
            return redirect()->to('/galeri')->with('error', 'Galeri tidak ditemukan');
        }

        $file_path = ROOTPATH . 'public/uploads/galeri/' . $galeri['nama_file'];
        if (!file_exists($file_path)) {
            return redirect()->to('/galeri')->with('error', 'File tidak ditemukan');
        }

        return $this->response->download($file_path, $galeri['nama_file']);
    }

    public function frontend()
    {
        $data = [
            'title' => 'Galeri Kegiatan',
            'galeri' => $this->galeriModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('frontend/galeri', $data);
    }
} 