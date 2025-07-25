<?php

namespace App\Controllers;

use App\Models\FaqModel;

class Faq extends BaseController
{
    protected $faqModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
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
            $data['faq'] = $this->faqModel->searchFaqs($search);
            $data['search'] = $search;
        } elseif ($status) {
            $data['faq'] = $this->faqModel->getFaqsByStatus($status);
            $data['status_filter'] = $status;
        } else {
            $data['faq'] = $this->faqModel->getAllFaqsOrdered();
        }

        $data['statistics'] = $this->faqModel->getStatistics();

        return view('backend/faq/index', $data);
    }

    public function create()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'jawaban' => $this->request->getPost('jawaban'),
                'urutan' => $this->request->getPost('urutan') ?: $this->faqModel->getNextUrutan(),
                'status' => $this->request->getPost('status') ?: 'aktif'
            ];

            if ($this->faqModel->insert($data)) {
                return redirect()->to('/faq')->with('success', 'FAQ berhasil ditambahkan.');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->faqModel->errors());
            }
        }

        return view('backend/faq/create');
    }

    public function edit($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/faq')->with('error', 'ID FAQ tidak ditemukan.');
        }

        $faq = $this->faqModel->find($id);
        if (!$faq) {
            return redirect()->to('/faq')->with('error', 'FAQ tidak ditemukan.');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'pertanyaan' => $this->request->getPost('pertanyaan'),
                'jawaban' => $this->request->getPost('jawaban'),
                'urutan' => $this->request->getPost('urutan'),
                'status' => $this->request->getPost('status')
            ];

            if ($this->faqModel->update($id, $data)) {
                return redirect()->to('/faq')->with('success', 'FAQ berhasil diperbarui.');
            } else {
                return redirect()->back()->withInput()->with('errors', $this->faqModel->errors());
            }
        }

        return view('backend/faq/edit', ['faq' => $faq]);
    }

    public function delete($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/faq')->with('error', 'ID FAQ tidak ditemukan.');
        }

        $faq = $this->faqModel->find($id);
        if (!$faq) {
            return redirect()->to('/faq')->with('error', 'FAQ tidak ditemukan.');
        }

        if ($this->faqModel->delete($id)) {
            return redirect()->to('/faq')->with('success', 'FAQ berhasil dihapus.');
        } else {
            return redirect()->to('/faq')->with('error', 'Gagal menghapus FAQ.');
        }
    }

    public function toggleStatus($id = null)
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($id === null) {
            return redirect()->to('/faq')->with('error', 'ID FAQ tidak ditemukan.');
        }

        if ($this->faqModel->toggleStatus($id)) {
            return redirect()->to('/faq')->with('success', 'Status FAQ berhasil diubah.');
        } else {
            return redirect()->to('/faq')->with('error', 'Gagal mengubah status FAQ.');
        }
    }

    public function reorder()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($this->request->getMethod() === 'post') {
            $faqIds = $this->request->getPost('faq_ids');
            
            if ($faqIds && is_array($faqIds)) {
                if ($this->faqModel->reorderFaqs($faqIds)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Urutan FAQ berhasil diperbarui.']);
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui urutan FAQ.']);
                }
            }
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Data tidak valid.']);
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
            return redirect()->to('/faq')->with('error', 'Pilih FAQ dan aksi yang akan dilakukan.');
        }

        $success = 0;
        $failed = 0;

        foreach ($selected as $id) {
            switch ($action) {
                case 'activate':
                    if ($this->faqModel->update($id, ['status' => 'aktif'])) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
                case 'deactivate':
                    if ($this->faqModel->update($id, ['status' => 'nonaktif'])) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
                case 'delete':
                    if ($this->faqModel->delete($id)) {
                        $success++;
                    } else {
                        $failed++;
                    }
                    break;
            }
        }

        $message = "Berhasil memproses {$success} FAQ.";
        if ($failed > 0) {
            $message .= " Gagal memproses {$failed} FAQ.";
        }

        return redirect()->to('/faq')->with('success', $message);
    }

    public function export()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $status = $this->request->getGet('status');
        
        if ($status) {
            $faqs = $this->faqModel->getFaqsByStatus($status);
        } else {
            $faqs = $this->faqModel->getAllFaqsOrdered();
        }

        // Set header untuk download CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="faq_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, [
            'ID', 'Pertanyaan', 'Jawaban', 'Urutan', 'Status', 'Created At', 'Updated At'
        ]);

        // Data CSV
        foreach ($faqs as $row) {
            fputcsv($output, [
                $row['id'],
                $row['pertanyaan'],
                $row['jawaban'],
                $row['urutan'],
                $row['status'],
                $row['created_at'],
                $row['updated_at']
            ]);
        }

        fclose($output);
        exit;
    }
} 