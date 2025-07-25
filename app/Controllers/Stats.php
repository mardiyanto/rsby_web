<?php
namespace App\Controllers;

use App\Models\StatsModel;

class Stats extends BaseController
{
    protected $statsModel;

    public function __construct()
    {
        $this->statsModel = new StatsModel();
    }

    private function requireAdmin()
    {
        $session = session();
        if (!$session->get('logged_in') || $session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login sebagai admin.');
        }
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        if ($search) {
            $stats = $this->statsModel->searchStats($search);
        } elseif ($status) {
            $stats = $this->statsModel->where('status', $status)->orderBy('urutan', 'ASC')->findAll();
        } else {
            $stats = $this->statsModel->getAllStatsOrdered();
        }
        return view('backend/stats/index', [
            'stats' => $stats
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        if ($this->request->getMethod() === 'post') {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'angka' => $this->request->getPost('angka'),
                'ikon' => $this->request->getPost('ikon'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'urutan' => $this->request->getPost('urutan') ?: $this->statsModel->getNextUrutan(),
                'status' => $this->request->getPost('status') ?: 'aktif'
            ];
            if ($this->statsModel->insert($data)) {
                return redirect()->to('/stats')->with('success', 'Stat berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->statsModel->errors());
            }
        }
        return view('backend/stats/create');
    }

    public function edit($id = null)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        if (!$id) return redirect()->to('/stats')->with('error', 'ID tidak ditemukan.');
        $stat = $this->statsModel->find($id);
        if (!$stat) return redirect()->to('/stats')->with('error', 'Data tidak ditemukan.');
        if ($this->request->getMethod() === 'post') {
            $data = [
                'judul' => $this->request->getPost('judul'),
                'angka' => $this->request->getPost('angka'),
                'ikon' => $this->request->getPost('ikon'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'urutan' => $this->request->getPost('urutan'),
                'status' => $this->request->getPost('status')
            ];
            if ($this->statsModel->update($id, $data)) {
                return redirect()->to('/stats')->with('success', 'Stat berhasil diupdate.');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->statsModel->errors());
            }
        }
        return view('backend/stats/edit', ['stat' => $stat]);
    }

    public function delete($id = null)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        if (!$id) return redirect()->to('/stats')->with('error', 'ID tidak ditemukan.');
        $stat = $this->statsModel->find($id);
        if (!$stat) return redirect()->to('/stats')->with('error', 'Data tidak ditemukan.');
        if ($this->statsModel->delete($id)) {
            return redirect()->to('/stats')->with('success', 'Stat berhasil dihapus.');
        } else {
            return redirect()->to('/stats')->with('error', 'Gagal menghapus stat.');
        }
    }

    public function toggleStatus($id = null)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        if (!$id) return redirect()->to('/stats')->with('error', 'ID tidak ditemukan.');
        if ($this->statsModel->toggleStatus($id)) {
            return redirect()->to('/stats')->with('success', 'Status berhasil diubah.');
        } else {
            return redirect()->to('/stats')->with('error', 'Gagal mengubah status.');
        }
    }

    public function reorder()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        if ($this->request->getMethod() === 'post') {
            $ids = $this->request->getPost('ids');
            if ($ids && is_array($ids)) {
                if ($this->statsModel->reorderStats($ids)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal update urutan.']);
                }
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
    }

    public function bulkAction()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        $action = $this->request->getPost('action');
        $selected = $this->request->getPost('selected');
        if (!$selected || !$action) {
            return redirect()->to('/stats')->with('error', 'Pilih data dan aksi yang akan dilakukan.');
        }
        $success = 0;
        $failed = 0;
        foreach ($selected as $id) {
            switch ($action) {
                case 'activate':
                    if ($this->statsModel->update($id, ['status' => 'aktif'])) $success++; else $failed++;
                    break;
                case 'deactivate':
                    if ($this->statsModel->update($id, ['status' => 'nonaktif'])) $success++; else $failed++;
                    break;
                case 'delete':
                    if ($this->statsModel->delete($id)) $success++; else $failed++;
                    break;
            }
        }
        $message = "Berhasil memproses {$success} data.";
        if ($failed > 0) $message .= " Gagal memproses {$failed} data.";
        return redirect()->to('/stats')->with('success', $message);
    }

    public function export()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        $status = $this->request->getGet('status');
        if ($status) {
            $stats = $this->statsModel->where('status', $status)->orderBy('urutan', 'ASC')->findAll();
        } else {
            $stats = $this->statsModel->getAllStatsOrdered();
        }
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="stats_' . date('Y-m-d') . '.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Judul', 'Angka', 'Ikon', 'Deskripsi', 'Urutan', 'Status', 'Created At', 'Updated At']);
        foreach ($stats as $row) {
            fputcsv($output, [
                $row['id'], $row['judul'], $row['angka'], $row['ikon'], $row['deskripsi'], $row['urutan'], $row['status'], $row['created_at'], $row['updated_at']
            ]);
        }
        fclose($output);
        exit;
    }

    public function getNextUrutan()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        $next = $this->statsModel->getNextUrutan();
        return $this->response->setJSON(['next_urutan' => $next]);
    }
} 