<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table = 'profil';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama_website', 'deskripsi', 'alamat', 'telepon', 'email', 
        'website', 'logo', 'favicon', 'facebook', 'twitter', 
        'instagram', 'youtube', 'jam_operasional', 'map_url', 'map_embed'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getProfil()
    {
        return $this->first();
    }

    public function updateProfil($data)
    {
        $profil = $this->first();
        if ($profil) {
            return $this->update($profil['id'], $data);
        } else {
            return $this->insert($data);
        }
    }

    public function uploadLogo($file)
    {
        if (!$file->isValid() || $file->hasMoved()) {
            return false;
        }

        $newName = $file->getRandomName();
        $uploadPath = FCPATH . 'uploads/profil/';
        
        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($file->move($uploadPath, $newName)) {
            // Hapus logo lama jika ada
            $profil = $this->first();
            if ($profil && $profil['logo'] && file_exists($uploadPath . $profil['logo'])) {
                unlink($uploadPath . $profil['logo']);
            }
            
            return $newName;
        }

        return false;
    }

    public function uploadFavicon($file)
    {
        if (!$file->isValid() || $file->hasMoved()) {
            return false;
        }

        $newName = $file->getRandomName();
        $uploadPath = FCPATH . 'uploads/profil/';
        
        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($file->move($uploadPath, $newName)) {
            // Hapus favicon lama jika ada
            $profil = $this->first();
            if ($profil && $profil['favicon'] && file_exists($uploadPath . $profil['favicon'])) {
                unlink($uploadPath . $profil['favicon']);
            }
            
            return $newName;
        }

        return false;
    }
}