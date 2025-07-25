<?php

namespace App\Controllers;

use App\Models\ProfilModel;

class Profil extends BaseController
{
    protected $profilModel;

    public function __construct()
    {
        $this->profilModel = new ProfilModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data['profil'] = $this->profilModel->getProfil();
        $data['title'] = 'Profil Website';
        
        return view('backend/profil/index', $data);
    }

    public function update()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $rules = [
            'nama_website' => 'required|min_length[3]',
            'deskripsi' => 'required|min_length[10]',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required|valid_email',
            'website' => 'required|valid_url',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_website' => $this->request->getPost('nama_website'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
            'facebook' => $this->request->getPost('facebook'),
            'twitter' => $this->request->getPost('twitter'),
            'instagram' => $this->request->getPost('instagram'),
            'youtube' => $this->request->getPost('youtube'),
            'jam_operasional' => $this->request->getPost('jam_operasional'),
            'map_url' => $this->request->getPost('map_url'),
            'map_embed' => $this->request->getPost('map_embed'),
        ];

        // Handle logo upload
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($logo->getMimeType(), $allowedTypes)) {
                $logoName = $this->profilModel->uploadLogo($logo);
                if ($logoName) {
                    $data['logo'] = $logoName;
                }
            }
        }

        // Handle favicon upload
        $favicon = $this->request->getFile('favicon');
        if ($favicon && $favicon->isValid() && !$favicon->hasMoved()) {
            $allowedTypes = ['image/x-icon', 'image/png'];
            if (in_array($favicon->getMimeType(), $allowedTypes)) {
                $faviconName = $this->profilModel->uploadFavicon($favicon);
                if ($faviconName) {
                    $data['favicon'] = $faviconName;
                }
            }
        }

        if ($this->profilModel->updateProfil($data)) {
            return redirect()->to('/profil')->with('success', 'Profil website berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil website');
        }
    }
}
