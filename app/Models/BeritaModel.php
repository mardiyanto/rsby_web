<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $allowedFields = ['id_kategori', 'judul', 'isi', 'gambar', 'penulis', 'tanggal_terbit', 'slug', 'view_count'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ['addKontenAlias'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Add konten alias for isi field
     */
    protected function addKontenAlias($data)
    {
        if (is_array($data)) {
            if (isset($data['data'])) {
                // Multiple results
                foreach ($data['data'] as &$row) {
                    if (isset($row['isi'])) {
                        $row['konten'] = $row['isi'];
                    }
                }
            } else {
                // Single result
                if (isset($data['isi'])) {
                    $data['konten'] = $data['isi'];
                }
            }
        }
        return $data;
    }

    public function getBeritaWithKategori()
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->orderBy('berita.created_at', 'DESC')
                    ->findAll();
    }

    public function getLatest($limit = 10)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->orderBy('berita.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getBeritaByKategori($id_kategori, $limit = 10)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->where('berita.id_kategori', $id_kategori)
                    ->orderBy('berita.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function searchBerita($keyword)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->like('berita.judul', $keyword)
                    ->orLike('berita.isi', $keyword)
                    ->orderBy('berita.created_at', 'DESC')
                    ->findAll();
    }
    
    public function getBeritaBySlug($slug)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->where('berita.slug', $slug)
                    ->first();
    }
    
    public function getBeritaById($id_berita)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->where('berita.id_berita', $id_berita)
                    ->first();
    }
    
    public function getRelatedBerita($id_berita, $id_kategori, $limit = 3)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->where('berita.id_berita !=', $id_berita)
                    ->where('berita.id_kategori', $id_kategori)
                    ->orderBy('berita.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    public function getAllWithSearch($search = '', $kategori = '', $page = 1, $perPage = 12)
    {
        $builder = $this->select('berita.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = berita.id_kategori');
        
        if ($search) {
            $builder->groupStart()
                    ->like('berita.judul', $search)
                    ->orLike('berita.isi', $search)
                    ->groupEnd();
        }
        
        if ($kategori) {
            $builder->where('berita.id_kategori', $kategori);
        }
        
        return $builder->orderBy('berita.created_at', 'DESC')
                       ->paginate($perPage, 'default', $page);
    }
    
    public function search($keyword, $limit = 5)
    {
        return $this->select('berita.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = berita.id_kategori')
                    ->groupStart()
                    ->like('berita.judul', $keyword)
                    ->orLike('berita.isi', $keyword)
                    ->groupEnd()
                    ->orderBy('berita.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    public function incrementViewCount($id_berita)
    {
        return $this->set('view_count', 'view_count + 1', false)
                    ->where('id_berita', $id_berita)
                    ->update();
    }
    
    public function isSlugExists($slug, $excludeId = null)
    {
        $query = $this->where('slug', $slug);
        if ($excludeId) {
            $query->where('id_berita !=', $excludeId);
        }
        return $query->first() !== null;
    }
    
    public function generateSlug($judul, $excludeId = null)
    {
        $slug = url_title($judul, '-', true);
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->isSlugExists($slug, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
} 