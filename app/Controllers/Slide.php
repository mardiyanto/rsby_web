<?php

namespace App\Controllers;

use App\Models\SlideModel;

class Slide extends BaseController
{
    protected $slideModel;

    public function __construct()
    {
        $this->slideModel = new SlideModel();
    }

    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Kelola Slide',
            'slide' => $this->slideModel->orderBy('urutan', 'ASC')->findAll()
        ];

        return view('backend/slide/index', $data);
    }

    public function create()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Slide'
        ];

        return view('backend/slide/create', $data);
    }

    public function store()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $link = $this->request->getPost('link');
        $urutan = $this->request->getPost('urutan');
        $status = $this->request->getPost('status');
        
        // Upload gambar
        $gambar = '';
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = ROOTPATH . 'public/uploads/slide/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $gambar = $newName;
        }

        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'gambar' => $gambar,
            'link' => $link,
            'urutan' => $urutan,
            'status' => $status
        ];

        if ($this->slideModel->insert($data)) {
            session()->setFlashdata('success', 'Slide berhasil ditambahkan!');
            return redirect()->to('/slide');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan slide!');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $slide = $this->slideModel->find($id);
        if (!$slide) {
            return redirect()->to('/slide')->with('error', 'Slide tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Slide',
            'slide' => $slide
        ];

        return view('backend/slide/edit', $data);
    }

    public function update($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $slide = $this->slideModel->find($id);
        if (!$slide) {
            return redirect()->to('/slide')->with('error', 'Slide tidak ditemukan!');
        }

        $judul = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $link = $this->request->getPost('link');
        $urutan = $this->request->getPost('urutan');
        $status = $this->request->getPost('status');
        
        $data = [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'link' => $link,
            'urutan' => $urutan,
            'status' => $status
        ];

        // Upload gambar baru jika ada
        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder jika belum ada
            $uploadPath = ROOTPATH . 'public/uploads/slide/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Hapus gambar lama
            if ($slide['gambar'] && file_exists($uploadPath . $slide['gambar'])) {
                unlink($uploadPath . $slide['gambar']);
            }
            
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);
            $data['gambar'] = $newName;
        }

        if ($this->slideModel->update($id, $data)) {
            session()->setFlashdata('success', 'Slide berhasil diupdate!');
            return redirect()->to('/slide');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate slide!');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $slide = $this->slideModel->find($id);
        if ($slide) {
            // Hapus gambar
            $uploadPath = ROOTPATH . 'public/uploads/slide/';
            if ($slide['gambar'] && file_exists($uploadPath . $slide['gambar'])) {
                unlink($uploadPath . $slide['gambar']);
            }
        }

        if ($this->slideModel->delete($id)) {
            session()->setFlashdata('success', 'Slide berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus slide!');
        }

        return redirect()->to('/slide');
    }

    public function toggleStatus($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $slide = $this->slideModel->find($id);
        if (!$slide) {
            return redirect()->to('/slide')->with('error', 'Slide tidak ditemukan!');
        }

        $newStatus = ($slide['status'] == 'aktif') ? 'nonaktif' : 'aktif';
        
        if ($this->slideModel->update($id, ['status' => $newStatus])) {
            session()->setFlashdata('success', 'Status slide berhasil diubah!');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah status slide!');
        }

        return redirect()->to('/slide');
    }
} 