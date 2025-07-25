<?php

namespace App\Controllers;

use App\Models\HalamanModel;

class Halaman extends BaseController
{
    protected $halamanModel;

    public function __construct()
    {
        $this->halamanModel = new HalamanModel();
    }

    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Kelola Halaman',
            'halaman' => $this->halamanModel->findAll()
        ];

        return view('backend/halaman/index', $data);
    }

    public function create()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Halaman'
        ];

        return view('backend/halaman/create', $data);
    }

    public function store()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $penulis = $this->request->getPost('penulis');
        $tanggal_publish = $this->request->getPost('tanggal_publish');
        
        // Generate slug dari judul
        $slug = url_title($judul, '-', TRUE);
        
        // Cek apakah slug sudah ada
        if ($this->halamanModel->isSlugExists($slug)) {
            $slug = $slug . '-' . time();
        }
        
        // Upload gambar
        $gambar = '';
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = ROOTPATH . 'public/uploads/halaman/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $gambar = $newName;
        }

        $data = [
            'judul' => $judul,
            'slug' => $slug,
            'konten' => $konten,
            'gambar' => $gambar,
            'penulis' => $penulis,
            'tanggal_publish' => $tanggal_publish
        ];

        if ($this->halamanModel->insert($data)) {
            session()->setFlashdata('success', 'Halaman berhasil ditambahkan!');
            return redirect()->to('/halaman');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan halaman!');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $halaman = $this->halamanModel->find($id);
        if (!$halaman) {
            return redirect()->to('/halaman')->with('error', 'Halaman tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Halaman',
            'halaman' => $halaman
        ];

        return view('backend/halaman/edit', $data);
    }

    public function update($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $halaman = $this->halamanModel->find($id);
        if (!$halaman) {
            return redirect()->to('/halaman')->with('error', 'Halaman tidak ditemukan!');
        }

        $judul = $this->request->getPost('judul');
        $konten = $this->request->getPost('konten');
        $penulis = $this->request->getPost('penulis');
        $tanggal_publish = $this->request->getPost('tanggal_publish');
        
        // Generate slug dari judul jika judul berubah
        $slug = $halaman['slug'];
        if ($judul !== $halaman['judul']) {
            $slug = url_title($judul, '-', TRUE);
            // Cek apakah slug sudah ada (kecuali untuk halaman ini sendiri)
            if ($this->halamanModel->isSlugExists($slug, $id)) {
                $slug = $slug . '-' . time();
            }
        }
        
        $data = [
            'judul' => $judul,
            'slug' => $slug,
            'konten' => $konten,
            'penulis' => $penulis,
            'tanggal_publish' => $tanggal_publish
        ];

        // Upload gambar baru jika ada
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = ROOTPATH . 'public/uploads/halaman/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Hapus gambar lama
            if ($halaman['gambar'] && file_exists($uploadPath . $halaman['gambar'])) {
                unlink($uploadPath . $halaman['gambar']);
            }
            
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['gambar'] = $newName;
        }

        if ($this->halamanModel->update($id, $data)) {
            session()->setFlashdata('success', 'Halaman berhasil diupdate!');
            return redirect()->to('/halaman');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate halaman!');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $halaman = $this->halamanModel->find($id);
        if ($halaman) {
            // Hapus gambar
            $uploadPath = ROOTPATH . 'public/uploads/halaman/';
            if ($halaman['gambar'] && file_exists($uploadPath . $halaman['gambar'])) {
                unlink($uploadPath . $halaman['gambar']);
            }
        }

        if ($this->halamanModel->delete($id)) {
            session()->setFlashdata('success', 'Halaman berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus halaman!');
        }

        return redirect()->to('/halaman');
    }

    // Method untuk frontend
    public function show($slug = null)
    {
        $halaman = $this->halamanModel->where('slug', $slug)->first();
        if (!$halaman) {
            return redirect()->to('/');
        }

        $data = [
            'title' => $halaman['judul'],
            'halaman' => $halaman
        ];

        return view('frontend/halaman/show', $data);
    }
} 