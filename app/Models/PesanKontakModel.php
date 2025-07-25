<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanKontakModel extends Model
{
    protected $table            = 'pesan_kontak';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama', 
        'email', 
        'telepon', 
        'subjek', 
        'pesan', 
        'status', 
        'tanggal_dibaca', 
        'tanggal_dibalas', 
        'catatan_admin'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'tanggal_kirim';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [
        'nama' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|max_length[255]',
        'telepon' => 'permit_empty|max_length[20]',
        'subjek' => 'required|max_length[255]',
        'pesan' => 'required|min_length[10]',
        'status' => 'required|in_list[baru,dibaca,dibalas]'
    ];
    protected $validationMessages   = [
        'nama' => [
            'required' => 'Nama harus diisi',
            'min_length' => 'Nama minimal 3 karakter',
            'max_length' => 'Nama maksimal 255 karakter'
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Format email tidak valid',
            'max_length' => 'Email maksimal 255 karakter'
        ],
        'telepon' => [
            'max_length' => 'Telepon maksimal 20 karakter'
        ],
        'subjek' => [
            'required' => 'Subjek harus diisi',
            'max_length' => 'Subjek maksimal 255 karakter'
        ],
        'pesan' => [
            'required' => 'Pesan harus diisi',
            'min_length' => 'Pesan minimal 10 karakter'
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
     * Get pesan by status
     */
    public function getPesanByStatus($status = null, $limit = null)
    {
        $builder = $this->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        $builder->orderBy('tanggal_kirim', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get pesan baru (belum dibaca)
     */
    public function getPesanBaru($limit = null)
    {
        return $this->getPesanByStatus('baru', $limit);
    }

    /**
     * Get pesan yang sudah dibaca
     */
    public function getPesanDibaca($limit = null)
    {
        return $this->getPesanByStatus('dibaca', $limit);
    }

    /**
     * Get pesan yang sudah dibalas
     */
    public function getPesanDibalas($limit = null)
    {
        return $this->getPesanByStatus('dibalas', $limit);
    }

    /**
     * Mark pesan as read
     */
    public function markAsRead($id)
    {
        return $this->update($id, [
            'status' => 'dibaca',
            'tanggal_dibaca' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Mark pesan as replied
     */
    public function markAsReplied($id, $catatan_admin = null)
    {
        $data = [
            'status' => 'dibalas',
            'tanggal_dibalas' => date('Y-m-d H:i:s')
        ];
        
        if ($catatan_admin) {
            $data['catatan_admin'] = $catatan_admin;
        }
        
        return $this->update($id, $data);
    }

    /**
     * Get statistics
     */
    public function getStatistics()
    {
        $total = $this->countAllResults();
        $baru = $this->where('status', 'baru')->countAllResults();
        $dibaca = $this->where('status', 'dibaca')->countAllResults();
        $dibalas = $this->where('status', 'dibalas')->countAllResults();
        
        return [
            'total' => $total,
            'baru' => $baru,
            'dibaca' => $dibaca,
            'dibalas' => $dibalas
        ];
    }

    /**
     * Get pesan per bulan untuk grafik
     */
    public function getPesanPerBulan($tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }
        
        return $this->select("COUNT(*) as jumlah, DATE_FORMAT(tanggal_kirim, '%Y-%m') as bulan")
            ->where('YEAR(tanggal_kirim)', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->findAll();
    }

    /**
     * Search pesan
     */
    public function searchPesan($keyword)
    {
        return $this->like('nama', $keyword)
                    ->orLike('email', $keyword)
                    ->orLike('subjek', $keyword)
                    ->orLike('pesan', $keyword)
                    ->orderBy('tanggal_kirim', 'DESC')
                    ->findAll();
    }
} 