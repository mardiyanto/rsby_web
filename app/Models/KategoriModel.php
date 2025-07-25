<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori'];


    public function getKategoriWithCount()
    {
        return $this->select('kategori.*, COUNT(berita.id_berita) as jumlah_berita')
                    ->join('berita', 'berita.id_kategori = kategori.id_kategori', 'left')
                    ->groupBy('kategori.id_kategori')
                    ->findAll();
    }
    
    public function getBeritaCountByKategori($id_kategori)
    {
        $beritaModel = new \App\Models\BeritaModel();
        return $beritaModel->where('id_kategori', $id_kategori)->countAllResults();
    }
} 