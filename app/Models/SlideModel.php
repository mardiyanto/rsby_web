<?php

namespace App\Models;

use CodeIgniter\Model;

class SlideModel extends Model
{
    protected $table = 'slide';
    protected $primaryKey = 'id_slide';
    protected $allowedFields = ['judul', 'deskripsi', 'gambar', 'link', 'urutan', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveSlides()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    public function getSlidesByStatus($status = 'aktif')
    {
        return $this->where('status', $status)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }
} 