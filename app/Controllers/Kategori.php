<?php
namespace App\Controllers;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
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

        $data['kategori'] = $this->kategoriModel->findAll();
        $data['title'] = 'Kategori Berita';
        
        return view('backend/kategori/index', $data);
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

        $data['title'] = 'Tambah Kategori Berita';
        return view('backend/kategori/create', $data);
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
            'nama_kategori' => [
                'rules' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori]',
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

        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ];

        try {
            $this->kategoriModel->insert($data);
            return redirect()->to('/kategori')->with('success', 'Kategori berita berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data');
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
            return redirect()->to('/kategori')->with('error', 'ID kategori tidak ditemukan');
        }

        $data['kategori'] = $this->kategoriModel->find($id);
        if (!$data['kategori']) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        $data['title'] = 'Edit Kategori Berita';
        return view('backend/kategori/edit', $data);
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
            return redirect()->to('/kategori')->with('error', 'ID kategori tidak ditemukan');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        $nama_kategori = $this->request->getPost('nama_kategori');
        
        // Cek apakah nama kategori sudah ada (kecuali untuk kategori yang sedang diedit)
        $existing = $this->kategoriModel->where('nama_kategori', $nama_kategori)
                                       ->where('id_kategori !=', $id)
                                       ->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Nama kategori sudah ada');
        }

        $rules = [
            'nama_kategori' => [
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
            'nama_kategori' => $nama_kategori
        ];

        try {
            $this->kategoriModel->update($id, $data);
            return redirect()->to('/kategori')->with('success', 'Kategori berita berhasil diperbarui');
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
            return redirect()->to('/kategori')->with('error', 'ID kategori tidak ditemukan');
        }

        $kategori = $this->kategoriModel->find($id);
        if (!$kategori) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak ditemukan');
        }

        // Cek apakah kategori masih digunakan di tabel berita
        $beritaModel = new \App\Models\BeritaModel();
        $berita_count = $beritaModel->where('id_kategori', $id)->countAllResults();
        
        if ($berita_count > 0) {
            return redirect()->to('/kategori')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $berita_count . ' berita');
        }

        try {
            $this->kategoriModel->delete($id);
            return redirect()->to('/kategori')->with('success', 'Kategori berita berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/kategori')->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
} 