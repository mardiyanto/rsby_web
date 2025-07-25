<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckerboardCarouselModel extends Model
{
    protected $table = 'checkerboard_carousel';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_layanan', 'deskripsi', 'ikon', 'slug', 'link', 'urutan', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveLayanan()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    public function getLayananByStatus($status = 'aktif')
    {
        return $this->where('status', $status)
                    ->orderBy('urutan', 'ASC')
                    ->findAll();
    }

    public function getLayananBySlug($slug)
    {
        return $this->where('slug', $slug)
                    ->where('status', 'aktif')
                    ->first();
    }

    public function getLayananForCarousel($limit = 12)
    {
        return $this->where('status', 'aktif')
                    ->orderBy('urutan', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getLayananPerSlide($itemsPerSlide = 4)
    {
        $layanan = $this->getActiveLayanan();
        $slides = [];
        $currentSlide = [];
        
        foreach ($layanan as $index => $item) {
            $currentSlide[] = $item;
            
            if (count($currentSlide) == $itemsPerSlide || $index == count($layanan) - 1) {
                $slides[] = $currentSlide;
                $currentSlide = [];
            }
        }
        
        return $slides;
    }

    public function getLayananStatistics()
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
} 