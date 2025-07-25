<?php
namespace App\Controllers;

use App\Models\KategoriDownloadModel;

class KategoriDownload extends BaseController
{
    protected $kategoriDownloadModel;

    public function __construct()
    {
        $this->kategoriDownloadModel = new KategoriDownloadModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard/' . $session->get('role'))->with('error', 'Anda tidak punya akses ke halaman ini.');
        }

        try {
            $data['kategori_download'] = $this->kategoriDownloadModel->getKategoriWithCount();
            $data['title'] = 'Kategori Download';
            
            return view('backend/kategori_download/index', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data kategori download');
        }
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

        $data['title'] = 'Tambah Kategori Download';
        return view('backend/kategori_download/create', $data);
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
            'nama_kategori_download' => [
                'rules' => 'required|min_length[3]|max_length[100]|is_unique[kategori_download.nama_kategori_download]',
                'errors' => [
                    'required' => 'Nama kategori harus diisi',
                    'min_length' => 'Nama kategori minimal 3 karakter',
                    'max_length' => 'Nama kategori maksimal 100 karakter',
                    'is_unique' => 'Nama kategori sudah ada'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama_kategori_download = trim($this->request->getPost('nama_kategori_download'));
        
        $data = [
            'nama_kategori_download' => $nama_kategori_download
        ];

        try {
            $this->kategoriDownloadModel->insert($data);
            return redirect()->to('/kategori-download')->with('success', 'Kategori download berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data kategori download');
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
            return redirect()->to('/kategori-download')->with('error', 'ID kategori tidak ditemukan');
        }

        try {
            $data['kategori'] = $this->kategoriDownloadModel->find($id);
            if (!$data['kategori']) {
                return redirect()->to('/kategori-download')->with('error', 'Kategori download tidak ditemukan');
            }

            $data['title'] = 'Edit Kategori Download';
            return view('backend/kategori_download/edit', $data);
        } catch (\Exception $e) {
            return redirect()->to('/kategori-download')->with('error', 'Terjadi kesalahan saat memuat data kategori download');
        }
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
            return redirect()->to('/kategori-download')->with('error', 'ID kategori tidak ditemukan');
        }

        try {
            $kategori = $this->kategoriDownloadModel->find($id);
            if (!$kategori) {
                return redirect()->to('/kategori-download')->with('error', 'Kategori download tidak ditemukan');
            }

            $nama_kategori_download = trim($this->request->getPost('nama_kategori_download'));
            
            // Cek apakah nama kategori sudah ada (kecuali untuk kategori yang sedang diedit)
            $existing = $this->kategoriDownloadModel->where('nama_kategori_download', $nama_kategori_download)
                                                   ->where('id_kategori_download !=', $id)
                                                   ->first();
            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'Nama kategori download sudah ada');
            }

            $rules = [
                'nama_kategori_download' => [
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required' => 'Nama kategori harus diisi',
                        'min_length' => 'Nama kategori minimal 3 karakter',
                        'max_length' => 'Nama kategori maksimal 100 karakter'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $data = [
                'nama_kategori_download' => $nama_kategori_download
            ];

            $this->kategoriDownloadModel->update($id, $data);
            return redirect()->to('/kategori-download')->with('success', 'Kategori download berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data kategori download');
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
            return redirect()->to('/kategori-download')->with('error', 'ID kategori tidak ditemukan');
        }

        try {
            $kategori = $this->kategoriDownloadModel->find($id);
            if (!$kategori) {
                return redirect()->to('/kategori-download')->with('error', 'Kategori download tidak ditemukan');
            }

            // Cek apakah kategori masih digunakan di tabel download
            $downloadModel = new \App\Models\DownloadModel();
            $download_count = $downloadModel->where('id_kategori_download', $id)->countAllResults();
            
            if ($download_count > 0) {
                return redirect()->to('/kategori-download')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $download_count . ' file download');
            }

            $this->kategoriDownloadModel->delete($id);
            return redirect()->to('/kategori-download')->with('success', 'Kategori download berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/kategori-download')->with('error', 'Terjadi kesalahan saat menghapus data kategori download');
        }
    }
} 