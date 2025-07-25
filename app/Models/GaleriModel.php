<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriModel extends Model
{
    protected $table            = 'galeri';
    protected $primaryKey       = 'id_galeri';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['judul', 'deskripsi', 'nama_file', 'tanggal_upload'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'nama_file' => 'required|max_length[255]',
        'tanggal_upload' => 'required|valid_date'
    ];
    protected $validationMessages   = [
        'judul' => [
            'required' => 'Judul galeri harus diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'nama_file' => [
            'required' => 'File gambar harus diupload',
            'max_length' => 'Nama file maksimal 255 karakter'
        ],
        'tanggal_upload' => [
            'required' => 'Tanggal upload harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
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
    protected $afterFind      = ['addGambarAlias'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Add gambar alias for nama_file field
     */
    protected function addGambarAlias($data)
    {
        if (is_array($data)) {
            if (isset($data['data'])) {
                // Multiple results
                foreach ($data['data'] as &$row) {
                    if (isset($row['nama_file'])) {
                        $row['gambar'] = $row['nama_file'];
                    }
                }
            } else {
                // Single result
                if (isset($data['nama_file'])) {
                    $data['gambar'] = $data['nama_file'];
                }
            }
        }
        return $data;
    }

    /**
     * Get latest galeri
     */
    public function getLatest($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get galeri by date range
     */
    public function getByDateRange($start_date, $end_date)
    {
        return $this->where('tanggal_upload >=', $start_date)
                    ->where('tanggal_upload <=', $end_date)
                    ->orderBy('tanggal_upload', 'DESC')
                    ->findAll();
    }

    /**
     * Search galeri
     */
    public function searchGaleri($keyword)
    {
        return $this->like('judul', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get galeri statistics
     */
    public function getGaleriStats()
    {
        $total = $this->countAllResults();
        $this_month = $this->where('MONTH(created_at)', date('m'))
                           ->where('YEAR(created_at)', date('Y'))
                           ->countAllResults();
        $this_year = $this->where('YEAR(created_at)', date('Y'))
                          ->countAllResults();

        return [
            'total' => $total,
            'this_month' => $this_month,
            'this_year' => $this_year
        ];
    }

    public function getAllWithSearch($search = '', $sort = 'latest')
    {
        $builder = $this->select('*');
        
        if ($search) {
            $builder->groupStart()
                    ->like('judul', $search)
                    ->orLike('deskripsi', $search)
                    ->groupEnd();
        }
        
        switch ($sort) {
            case 'oldest':
                $builder->orderBy('created_at', 'ASC');
                break;
            case 'az':
                $builder->orderBy('judul', 'ASC');
                break;
            case 'za':
                $builder->orderBy('judul', 'DESC');
                break;
            default:
                $builder->orderBy('created_at', 'DESC');
                break;
        }
        
        return $builder->findAll();
    }
} 