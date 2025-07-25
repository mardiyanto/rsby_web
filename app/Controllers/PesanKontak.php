<?php

namespace App\Controllers;

use App\Models\PesanKontakModel;

class PesanKontak extends BaseController
{
    protected $pesanKontakModel;

    public function __construct()
    {
        $this->pesanKontakModel = new PesanKontakModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $status = $this->request->getGet('status');
        $search = $this->request->getGet('search');

        $data = [];

        if ($search) {
            $data['pesan'] = $this->pesanKontakModel->searchPesan($search);
            $data['search'] = $search;
        } elseif ($status) {
            $data['pesan'] = $this->pesanKontakModel->getPesanByStatus($status);
            $data['status_filter'] = $status;
        } else {
            $data['pesan'] = $this->pesanKontakModel->orderBy('tanggal_kirim', 'DESC')->findAll();
        }

        $data['statistics'] = $this->pesanKontakModel->getStatistics();

        return view('backend/pesan_kontak/index', $data);
    }

    public function show($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/pesan-kontak')->with('error', 'ID pesan tidak ditemukan.');
        }

        $pesan = $this->pesanKontakModel->find($id);
        if (!$pesan) {
            return redirect()->to('/pesan-kontak')->with('error', 'Pesan tidak ditemukan.');
        }

        // Mark as read if status is baru
        if ($pesan['status'] === 'baru') {
            $this->pesanKontakModel->markAsRead($id);
            $pesan['status'] = 'dibaca';
            $pesan['tanggal_dibaca'] = date('Y-m-d H:i:s');
        }

        return view('backend/pesan_kontak/show', ['pesan' => $pesan]);
    }

    public function reply($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/pesan-kontak')->with('error', 'ID pesan tidak ditemukan.');
        }

        $pesan = $this->pesanKontakModel->find($id);
        if (!$pesan) {
            return redirect()->to('/pesan-kontak')->with('error', 'Pesan tidak ditemukan.');
        }

        if ($this->request->getMethod() === 'post') {
            $catatan_admin = $this->request->getPost('catatan_admin');
            
            if ($this->pesanKontakModel->markAsReplied($id, $catatan_admin)) {
                return redirect()->to('/pesan-kontak')->with('success', 'Pesan berhasil ditandai sebagai dibalas.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui status pesan.');
            }
        }

        return view('backend/pesan_kontak/reply', ['pesan' => $pesan]);
    }

    public function delete($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/pesan-kontak')->with('error', 'ID pesan tidak ditemukan.');
        }

        $pesan = $this->pesanKontakModel->find($id);
        if (!$pesan) {
            return redirect()->to('/pesan-kontak')->with('error', 'Pesan tidak ditemukan.');
        }

        if ($this->pesanKontakModel->delete($id)) {
            return redirect()->to('/pesan-kontak')->with('success', 'Pesan berhasil dihapus.');
        } else {
            return redirect()->to('/pesan-kontak')->with('error', 'Gagal menghapus pesan.');
        }
    }

    public function markAsRead($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/pesan-kontak')->with('error', 'ID pesan tidak ditemukan.');
        }

        if ($this->pesanKontakModel->markAsRead($id)) {
            return redirect()->to('/pesan-kontak')->with('success', 'Pesan berhasil ditandai sebagai dibaca.');
        } else {
            return redirect()->to('/pesan-kontak')->with('error', 'Gagal memperbarui status pesan.');
        }
    }

    public function markAsReplied($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/pesan-kontak')->with('error', 'ID pesan tidak ditemukan.');
        }

        $catatan_admin = $this->request->getPost('catatan_admin');
        
        if ($this->pesanKontakModel->markAsReplied($id, $catatan_admin)) {
            return redirect()->to('/pesan-kontak')->with('success', 'Pesan berhasil ditandai sebagai dibalas.');
        } else {
            return redirect()->to('/pesan-kontak')->with('error', 'Gagal memperbarui status pesan.');
        }
    }

    public function bulkAction()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $action = $this->request->getPost('action');
        $selected = $this->request->getPost('selected');

        if (!$selected || !$action) {
            return redirect()->to('/pesan-kontak')->with('error', 'Pilih pesan dan aksi yang akan dilakukan.');
        }

        $success = 0;
        $failed = 0;

        foreach ($selected as $id) {
            switch ($action) {
                case 'mark_read':
                    if ($this->pesanKontakModel->markAsRead($id)) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
                case 'mark_replied':
                    if ($this->pesanKontakModel->markAsReplied($id)) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
                case 'delete':
                    if ($this->pesanKontakModel->delete($id)) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
            }
        }

        $message = "Berhasil memproses {$success} pesan.";
        if ($failed > 0) {
            $message .= " Gagal memproses {$failed} pesan.";
        }

        return redirect()->to('/pesan-kontak')->with('success', $message);
    }

    public function export()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $status = $this->request->getGet('status');
        
        if ($status) {
            $pesan = $this->pesanKontakModel->getPesanByStatus($status);
        } else {
            $pesan = $this->pesanKontakModel->orderBy('tanggal_kirim', 'DESC')->findAll();
        }

        // Set header untuk download CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="pesan_kontak_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, [
            'ID', 'Nama', 'Email', 'Telepon', 'Subjek', 'Pesan', 
            'Status', 'Tanggal Kirim', 'Tanggal Dibaca', 'Tanggal Dibalas', 'Catatan Admin'
        ]);

        // Data CSV
        foreach ($pesan as $row) {
            fputcsv($output, [
                $row['id'],
                $row['nama'],
                $row['email'],
                $row['telepon'],
                $row['subjek'],
                $row['pesan'],
                $row['status'],
                $row['tanggal_kirim'],
                $row['tanggal_dibaca'],
                $row['tanggal_dibalas'],
                $row['catatan_admin']
            ]);
        }

        fclose($output);
        exit;
    }
} 