<?php

namespace App\Models;

use CodeIgniter\Model;

class HalamanModel extends Model
{
    protected $table = 'halaman';
    protected $primaryKey = 'id_halaman';
    protected $allowedFields = ['judul', 'slug', 'konten', 'gambar', 'penulis', 'tanggal_publish'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'judul' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|min_length[3]|max_length[255]|is_unique[halaman.slug,id_halaman,{id_halaman}]',
        'konten' => 'required|min_length[10]',
        'penulis' => 'permit_empty|max_length[100]',
        'tanggal_publish' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul harus diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'slug' => [
            'required' => 'Slug harus diisi',
            'min_length' => 'Slug minimal 3 karakter',
            'max_length' => 'Slug maksimal 255 karakter',
            'is_unique' => 'Slug sudah digunakan'
        ],
        'konten' => [
            'required' => 'Konten harus diisi',
            'min_length' => 'Konten minimal 10 karakter'
        ],
        'penulis' => [
            'max_length' => 'Penulis maksimal 100 karakter'
        ],
        'tanggal_publish' => [
            'valid_date' => 'Format tanggal tidak valid'
        ]
    ];

    public function getHalamanBySlug($slug)
    {
        if (empty($slug)) {
            return null;
        }
        
        return $this->where('slug', $slug)
                    ->where('tanggal_publish <=', date('Y-m-d'))
                    ->first();
    }

    public function getPublishedHalaman()
    {
        return $this->where('tanggal_publish <=', date('Y-m-d'))
                    ->orderBy('tanggal_publish', 'DESC')
                    ->findAll();
    }

    public function getActiveHalaman($limit = null)
    {
        $builder = $this->builder();
        $builder->where('tanggal_publish <=', date('Y-m-d'))
                ->orderBy('tanggal_publish', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    public function isSlugExists($slug, $excludeId = null)
    {
        if (empty($slug)) {
            return false;
        }
        
        $query = $this->where('slug', $slug);
        if ($excludeId) {
            $query->where('id_halaman !=', $excludeId);
        }
        return $query->first() !== null;
    }
    
    public function search($keyword, $limit = 5)
    {
        if (empty($keyword)) {
            return [];
        }
        
        return $this->groupStart()
                    ->like('judul', $keyword)
                    ->orLike('konten', $keyword)
                    ->groupEnd()
                    ->where('tanggal_publish <=', date('Y-m-d'))
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function generateSlug($judul, $excludeId = null)
    {
        $slug = url_title($judul, '-', TRUE);
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->isSlugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    public function getHalamanForFrontend($slug = null)
    {
        if ($slug) {
            return $this->getHalamanBySlug($slug);
        }
        
        return $this->getActiveHalaman();
    }

    public function getHalamanById($id)
    {
        if (empty($id)) {
            return null;
        }
        
        return $this->find($id);
    }
} 