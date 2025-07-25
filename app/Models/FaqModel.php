<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'faq';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pertanyaan', 
        'jawaban', 
        'urutan', 
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'pertanyaan' => 'required|min_length[10]',
        'jawaban' => 'required|min_length[20]',
        'urutan' => 'required|integer|greater_than[0]',
        'status' => 'required|in_list[aktif,nonaktif]'
    ];
    protected $validationMessages   = [
        'pertanyaan' => [
            'required' => 'Pertanyaan harus diisi',
            'min_length' => 'Pertanyaan minimal 10 karakter'
        ],
        'jawaban' => [
            'required' => 'Jawaban harus diisi',
            'min_length' => 'Jawaban minimal 20 karakter'
        ],
        'urutan' => [
            'required' => 'Urutan harus diisi',
            'integer' => 'Urutan harus berupa angka',
            'greater_than' => 'Urutan harus lebih dari 0'
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status tidak valid'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get active FAQs ordered by urutan
     */
    public function getActiveFaqs($limit = null)
    {
        $builder = $this->builder();
        $builder->where('status', 'aktif')
                ->orderBy('urutan', 'ASC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get all FAQs ordered by urutan
     */
    public function getAllFaqsOrdered()
    {
        return $this->orderBy('urutan', 'ASC')->findAll();
    }

    /**
     * Get FAQ by status
     */
    public function getFaqsByStatus($status = null, $limit = null)
    {
        $builder = $this->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        $builder->orderBy('urutan', 'ASC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get next urutan number
     */
    public function getNextUrutan()
    {
        $result = $this->select('MAX(urutan) as max_urutan')->first();
        return ($result['max_urutan'] ?? 0) + 1;
    }

    /**
     * Update urutan for multiple FAQs
     */
    public function updateUrutan($id, $newUrutan)
    {
        return $this->update($id, ['urutan' => $newUrutan]);
    }

    /**
     * Reorder FAQs
     */
    public function reorderFaqs($faqIds)
    {
        $urutan = 1;
        foreach ($faqIds as $id) {
            $this->update($id, ['urutan' => $urutan]);
            $urutan++;
        }
        return true;
    }

    /**
     * Toggle status
     */
    public function toggleStatus($id)
    {
        $faq = $this->find($id);
        if (!$faq) {
            return false;
        }
        
        $newStatus = ($faq['status'] == 'aktif') ? 'nonaktif' : 'aktif';
        return $this->update($id, ['status' => $newStatus]);
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $total = $this->countAllResults();
        $aktif = $this->where('status', 'aktif')->countAllResults();
        $nonaktif = $this->where('status', 'nonaktif')->countAllResults();
        
        return [
            'total' => $total,
            'aktif' => $aktif,
            'nonaktif' => $nonaktif
        ];
    }

    /**
     * Search FAQs
     */
    public function searchFaqs($keyword)
    {
        return $this->like('pertanyaan', $keyword)
                    ->orLike('jawaban', $keyword)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    /**
     * Get FAQs for frontend
     */
    public function getFaqsForFrontend($limit = null)
    {
        $faqs = $this->getActiveFaqs($limit);
        
        // Add fallback data if no FAQs found
        if (empty($faqs)) {
            $faqs = [
                [
                    'id' => 1,
                    'pertanyaan' => 'Bagaimana cara mendaftar untuk layanan kesehatan di Biddokkes POLRI?',
                    'jawaban' => 'Untuk mendaftar layanan kesehatan, Anda dapat menghubungi kami melalui telepon atau datang langsung ke kantor kami. Tim kami akan membantu proses pendaftaran dan memberikan informasi lengkap tentang layanan yang tersedia.',
                    'urutan' => 1
                ],
                [
                    'id' => 2,
                    'pertanyaan' => 'Apakah layanan kesehatan tersedia 24 jam?',
                    'jawaban' => 'Layanan darurat tersedia 24 jam untuk kasus-kasus tertentu. Namun untuk layanan umum, kami beroperasi sesuai jam kerja yang telah ditentukan. Silakan hubungi kami untuk informasi lebih lanjut.',
                    'urutan' => 2
                ],
                [
                    'id' => 3,
                    'pertanyaan' => 'Dokter spesialis apa saja yang tersedia?',
                    'jawaban' => 'Kami memiliki berbagai dokter spesialis termasuk dokter umum, spesialis penyakit dalam, spesialis bedah, spesialis jantung, spesialis mata, dan lainnya. Silakan hubungi kami untuk jadwal konsultasi.',
                    'urutan' => 3
                ],
                [
                    'id' => 4,
                    'pertanyaan' => 'Bagaimana cara mengajukan keluhan atau saran?',
                    'jawaban' => 'Anda dapat mengajukan keluhan atau saran melalui form kontak di halaman ini, email, atau datang langsung ke kantor kami. Tim kami akan merespons dan menindaklanjuti setiap keluhan atau saran yang masuk.',
                    'urutan' => 4
                ]
            ];
        }
        
        return $faqs;
    }
} 