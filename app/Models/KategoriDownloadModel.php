<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriDownloadModel extends Model
{
    protected $table = 'kategori_download';
    protected $primaryKey = 'id_kategori_download';
    protected $allowedFields = ['nama_kategori_download', 'created_at'];
    protected $useTimestamps = false; // Karena created_at dihandle manual di database

    public function getKategoriWithCount()
    {
        return $this->select('kategori_download.*, COUNT(download.id_download) as jumlah_download')
                    ->join('download', 'download.id_kategori_download = kategori_download.id_kategori_download', 'left')
                    ->groupBy('kategori_download.id_kategori_download')
                    ->findAll();
    }
} 