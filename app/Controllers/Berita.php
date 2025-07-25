<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use App\Models\KategoriModel;

class Berita extends BaseController
{
    protected $beritaModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Kelola Berita',
            'berita' => $this->beritaModel->getBeritaWithKategori()
        ];

        return view('backend/berita/index', $data);
    }

    public function create()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Berita',
            'kategori' => $this->kategoriModel->findAll(),
            'penulis' => session()->get('nama') // Ambil nama dari session
        ];

        return view('backend/berita/create', $data);
    }

    public function store()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $judul = $this->request->getPost('judul');
        $id_kategori = $this->request->getPost('id_kategori');
        $isi = $this->request->getPost('isi');
        $penulis = $this->request->getPost('penulis');
        $tanggal_terbit = $this->request->getPost('tanggal_terbit');
        
        // Generate slug dari judul
        $slug = $this->generateSlug($judul);
        
        // Upload gambar
        $gambar = '';
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = ROOTPATH . 'public/uploads/artikel/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $gambar = $newName;
        }

        $data = [
            'id_kategori' => $id_kategori,
            'judul' => $judul,
            'slug' => $slug,
            'isi' => $isi,
            'gambar' => $gambar,
            'penulis' => $penulis,
            'tanggal_terbit' => $tanggal_terbit
        ];

        if ($this->beritaModel->insert($data)) {
            session()->setFlashdata('success', 'Berita berhasil ditambahkan!');
            return redirect()->to('/berita');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan berita!');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Berita',
            'berita' => $berita,
            'kategori' => $this->kategoriModel->findAll(),
            'penulis' => session()->get('nama') // Ambil nama dari session
        ];

        return view('backend/berita/edit', $data);
    }

    public function update($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/berita')->with('error', 'Berita tidak ditemukan!');
        }

        $judul = $this->request->getPost('judul');
        $id_kategori = $this->request->getPost('id_kategori');
        $isi = $this->request->getPost('isi');
        $penulis = $this->request->getPost('penulis');
        $tanggal_terbit = $this->request->getPost('tanggal_terbit');
        
        // Generate slug dari judul jika berubah
        $slug = $berita['slug'];
        if ($judul != $berita['judul']) {
            $slug = $this->generateSlug($judul);
        }
        
        $data = [
            'id_kategori' => $id_kategori,
            'judul' => $judul,
            'slug' => $slug,
            'isi' => $isi,
            'penulis' => $penulis,
            'tanggal_terbit' => $tanggal_terbit
        ];

        // Upload gambar baru jika ada
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = ROOTPATH . 'public/uploads/artikel/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Hapus gambar lama
            if ($berita['gambar'] && file_exists($uploadPath . $berita['gambar'])) {
                unlink($uploadPath . $berita['gambar']);
            }
            
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['gambar'] = $newName;
        }

        if ($this->beritaModel->update($id, $data)) {
            session()->setFlashdata('success', 'Berita berhasil diupdate!');
            return redirect()->to('/berita');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate berita!');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $berita = $this->beritaModel->find($id);
        if ($berita) {
            // Hapus gambar
            $uploadPath = ROOTPATH . 'public/uploads/artikel/';
            if ($berita['gambar'] && file_exists($uploadPath . $berita['gambar'])) {
                unlink($uploadPath . $berita['gambar']);
            }
        }

        if ($this->beritaModel->delete($id)) {
            session()->setFlashdata('success', 'Berita berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus berita!');
        }

        return redirect()->to('/berita');
    }

    /**
     * Generate slug dari judul berita
     */
    private function generateSlug($judul)
    {
        // Convert ke lowercase
        $slug = strtolower($judul);
        
        // Replace karakter khusus dengan dash
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        
        // Replace spasi dengan dash
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        
        // Remove dash di awal dan akhir
        $slug = trim($slug, '-');
        
        // Jika slug kosong, gunakan 'berita'
        if (empty($slug)) {
            $slug = 'berita';
        }
        
        // Cek apakah slug sudah ada, jika ya tambahkan timestamp
        $existingSlug = $this->beritaModel->where('slug', $slug)->first();
        if ($existingSlug) {
            $slug = $slug . '-' . time();
        }
        
        return $slug;
    }

    /**
     * API untuk generate slug (untuk AJAX)
     */
    public function generateSlugAjax()
    {
        $judul = $this->request->getPost('judul');
        $slug = $this->generateSlug($judul);
        
        return $this->response->setJSON(['slug' => $slug]);
    }
} 