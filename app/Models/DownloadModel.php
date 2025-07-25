<?php

namespace App\Models;

use CodeIgniter\Model;

class DownloadModel extends Model
{
    protected $table = 'download';
    protected $primaryKey = 'id_download';
    protected $allowedFields = [
        'id_kategori_download', 
        'judul', 
        'deskripsi', 
        'download_count',
        'nama_file', 
        'ukuran_file', 
        'tipe_file', 
        'hits',
        'tanggal_upload',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = false; // Karena created_at dan updated_at dihandle manual di database

    public function getDownloadWithKategori()
    {
        return $this->select('download.*, kategori_download.nama_kategori_download')
                    ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download')
                    ->orderBy('download.created_at', 'DESC')
                    ->findAll();
    }

    public function getLatest($limit = 10)
    {
        return $this->select('download.*, kategori_download.nama_kategori_download')
                    ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download')
                    ->orderBy('download.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getDownloadByKategori($id_kategori_download, $limit = 10)
    {
        return $this->select('download.*, kategori_download.nama_kategori_download')
                    ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download')
                    ->where('download.id_kategori_download', $id_kategori_download)
                    ->orderBy('download.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getPopularDownloads($limit = 10)
    {
        return $this->select('download.*, kategori_download.nama_kategori_download')
                    ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download')
                    ->orderBy('download.hits', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function searchDownload($keyword)
    {
        return $this->select('download.*, kategori_download.nama_kategori_download')
                    ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download')
                    ->like('download.judul', $keyword)
                    ->orLike('download.deskripsi', $keyword)
                    ->orderBy('download.created_at', 'DESC')
                    ->findAll();
    }

    public function search($keyword, $limit = 5)
    {
        return $this->select('download.*, kategori_download.nama_kategori_download')
                    ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download')
                    ->groupStart()
                    ->like('download.judul', $keyword)
                    ->orLike('download.deskripsi', $keyword)
                    ->groupEnd()
                    ->orderBy('download.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    
    public function getAllWithSearch($search = '', $kategori = '', $page = 1, $perPage = 12)
    {
        $builder = $this->select('download.*, kategori_download.nama_kategori_download')
                        ->join('kategori_download', 'kategori_download.id_kategori_download = download.id_kategori_download');
        
        if ($search) {
            $builder->groupStart()
                    ->like('download.judul', $search)
                    ->orLike('download.deskripsi', $search)
                    ->groupEnd();
        }
        
        if ($kategori) {
            $builder->where('download.id_kategori_download', $kategori);
        }
        
        return $builder->orderBy('download.created_at', 'DESC')
                       ->paginate($perPage, 'default', $page);
    }

    public function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
} 