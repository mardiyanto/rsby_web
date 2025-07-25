<?php

namespace App\Controllers;

use App\Models\CheckerboardCarouselModel;

class CheckerboardCarousel extends BaseController
{
    protected $checkerboardCarouselModel;

    public function __construct()
    {
        $this->checkerboardCarouselModel = new CheckerboardCarouselModel();
    }

    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Kelola Checkerboard Carousel',
            'layanan' => $this->checkerboardCarouselModel->orderBy('urutan', 'ASC')->findAll(),
            'statistics' => $this->checkerboardCarouselModel->getLayananStatistics()
        ];

        return view('backend/checkerboard_carousel/index', $data);
    }

    public function create()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah Layanan'
        ];

        return view('backend/checkerboard_carousel/create', $data);
    }

    public function store()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $nama_layanan = $this->request->getPost('nama_layanan');
        $deskripsi = $this->request->getPost('deskripsi');
        $ikon = $this->request->getPost('ikon');
        $link = $this->request->getPost('link');
        $urutan = $this->request->getPost('urutan');
        $status = $this->request->getPost('status');
        
        // Generate slug dari nama layanan
        $slug = url_title($nama_layanan, '-', TRUE);
        
        // Cek apakah slug sudah ada
        $existingSlug = $this->checkerboardCarouselModel->where('slug', $slug)->first();
        if ($existingSlug) {
            $slug = $slug . '-' . time();
        }

        $data = [
            'nama_layanan' => $nama_layanan,
            'deskripsi' => $deskripsi,
            'ikon' => $ikon,
            'slug' => $slug,
            'link' => $link,
            'urutan' => $urutan,
            'status' => $status
        ];

        if ($this->checkerboardCarouselModel->insert($data)) {
            session()->setFlashdata('success', 'Layanan berhasil ditambahkan!');
            return redirect()->to('/checkerboard-carousel');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan layanan!');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $layanan = $this->checkerboardCarouselModel->find($id);
        if (!$layanan) {
            return redirect()->to('/checkerboard-carousel')->with('error', 'Layanan tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Layanan',
            'layanan' => $layanan
        ];

        return view('backend/checkerboard_carousel/edit', $data);
    }

    public function update($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $layanan = $this->checkerboardCarouselModel->find($id);
        if (!$layanan) {
            return redirect()->to('/checkerboard-carousel')->with('error', 'Layanan tidak ditemukan!');
        }

        $nama_layanan = $this->request->getPost('nama_layanan');
        $deskripsi = $this->request->getPost('deskripsi');
        $ikon = $this->request->getPost('ikon');
        $link = $this->request->getPost('link');
        $urutan = $this->request->getPost('urutan');
        $status = $this->request->getPost('status');
        
        // Generate slug dari nama layanan jika berubah
        $slug = $layanan['slug'];
        if ($nama_layanan != $layanan['nama_layanan']) {
            $slug = url_title($nama_layanan, '-', TRUE);
            
            // Cek apakah slug sudah ada (kecuali untuk record ini sendiri)
            $existingSlug = $this->checkerboardCarouselModel->where('slug', $slug)
                                                           ->where('id !=', $id)
                                                           ->first();
            if ($existingSlug) {
                $slug = $slug . '-' . time();
            }
        }

        $data = [
            'nama_layanan' => $nama_layanan,
            'deskripsi' => $deskripsi,
            'ikon' => $ikon,
            'slug' => $slug,
            'link' => $link,
            'urutan' => $urutan,
            'status' => $status
        ];

        if ($this->checkerboardCarouselModel->update($id, $data)) {
            session()->setFlashdata('success', 'Layanan berhasil diupdate!');
            return redirect()->to('/checkerboard-carousel');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate layanan!');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($this->checkerboardCarouselModel->delete($id)) {
            session()->setFlashdata('success', 'Layanan berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus layanan!');
        }

        return redirect()->to('/checkerboard-carousel');
    }

    public function toggleStatus($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $layanan = $this->checkerboardCarouselModel->find($id);
        if (!$layanan) {
            return redirect()->to('/checkerboard-carousel')->with('error', 'Layanan tidak ditemukan!');
        }

        $newStatus = ($layanan['status'] == 'aktif') ? 'nonaktif' : 'aktif';
        
        if ($this->checkerboardCarouselModel->update($id, ['status' => $newStatus])) {
            session()->setFlashdata('success', 'Status layanan berhasil diubah!');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah status layanan!');
        }

        return redirect()->to('/checkerboard-carousel');
    }

    public function reorder()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $orders = $this->request->getPost('orders');
        
        if (is_array($orders)) {
            foreach ($orders as $order) {
                $this->checkerboardCarouselModel->update($order['id'], ['urutan' => $order['urutan']]);
            }
            return $this->response->setJSON(['success' => true, 'message' => 'Urutan berhasil diubah']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid']);
    }
} 