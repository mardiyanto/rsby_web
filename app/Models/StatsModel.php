<?php
namespace App\Models;

use CodeIgniter\Model;

class StatsModel extends Model
{
    protected $table            = 'stats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul', 'angka', 'ikon', 'deskripsi', 'urutan', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'angka' => 'required|max_length[50]',
        'ikon' => 'required|max_length[100]',
        'urutan' => 'required|integer|greater_than[0]',
        'status' => 'required|in_list[aktif,nonaktif]'
    ];
    protected $validationMessages   = [
        'judul' => [
            'required' => 'Judul harus diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'angka' => [
            'required' => 'Angka harus diisi',
            'max_length' => 'Angka maksimal 50 karakter'
        ],
        'ikon' => [
            'required' => 'Ikon harus diisi',
            'max_length' => 'Class ikon maksimal 100 karakter'
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

    // Get all stats ordered
    public function getAllStatsOrdered()
    {
        return $this->orderBy('urutan', 'ASC')->findAll();
    }

    // Get only active stats for frontend
    public function getActiveStats($limit = null)
    {
        $builder = $this->builder();
        $builder->where('status', 'aktif')->orderBy('urutan', 'ASC');
        if ($limit) {
            $builder->limit($limit);
        }
        return $builder->get()->getResultArray();
    }

    // Get next urutan
    public function getNextUrutan()
    {
        $result = $this->select('MAX(urutan) as max_urutan')->first();
        return ($result['max_urutan'] ?? 0) + 1;
    }

    // Reorder stats
    public function reorderStats($ids)
    {
        $urutan = 1;
        foreach ($ids as $id) {
            $this->update($id, ['urutan' => $urutan]);
            $urutan++;
        }
        return true;
    }

    // Toggle status aktif/nonaktif
    public function toggleStatus($id)
    {
        $stat = $this->find($id);
        if (!$stat) return false;
        $newStatus = ($stat['status'] == 'aktif') ? 'nonaktif' : 'aktif';
        return $this->update($id, ['status' => $newStatus]);
    }

    // Search
    public function searchStats($keyword)
    {
        return $this->like('judul', $keyword)
                    ->orLike('angka', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }
} 