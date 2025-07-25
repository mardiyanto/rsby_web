<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Kelola User',
            'users' => $this->userModel->findAll()
        ];

        return view('backend/user/index', $data);
    }

    public function create()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Tambah User'
        ];

        return view('backend/user/create', $data);
    }

    public function store()
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');
        $role = $this->request->getPost('role');
        $nama = $this->request->getPost('nama');

        // Validasi password confirmation
        if ($password !== $password_confirm) {
            session()->setFlashdata('error', 'Konfirmasi password tidak cocok!');
            return redirect()->back()->withInput();
        }

        // Cek username sudah ada atau belum
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser) {
            session()->setFlashdata('error', 'Username sudah digunakan!');
            return redirect()->back()->withInput();
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'username' => $username,
            'password' => $hashedPassword,
            'role' => $role,
            'nama' => $nama
        ];

        if ($this->userModel->insert($data)) {
            session()->setFlashdata('success', 'User berhasil ditambahkan!');
            return redirect()->to('/user');
        } else {
            session()->setFlashdata('error', 'Gagal menambahkan user!');
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek user tidak bisa edit dirinya sendiri
        if ($id == session()->get('user_id')) {
            return redirect()->to('/user')->with('error', 'Anda tidak bisa mengedit akun sendiri!');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('backend/user/edit', $data);
    }

    public function update($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek user tidak bisa edit dirinya sendiri
        if ($id == session()->get('user_id')) {
            return redirect()->to('/user')->with('error', 'Anda tidak bisa mengedit akun sendiri!');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan!');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $password_confirm = $this->request->getPost('password_confirm');
        $role = $this->request->getPost('role');
        $nama = $this->request->getPost('nama');

        $data = [
            'username' => $username,
            'role' => $role,
            'nama' => $nama
        ];

        // Cek username sudah ada atau belum (kecuali user yang sedang diedit)
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser && $existingUser['id'] != $id) {
            session()->setFlashdata('error', 'Username sudah digunakan!');
            return redirect()->back()->withInput();
        }

        // Update password jika diisi
        if (!empty($password)) {
            if ($password !== $password_confirm) {
                session()->setFlashdata('error', 'Konfirmasi password tidak cocok!');
                return redirect()->back()->withInput();
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->userModel->update($id, $data)) {
            session()->setFlashdata('success', 'User berhasil diupdate!');
            return redirect()->to('/user');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate user!');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        // Cek login dan role admin
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek user tidak bisa hapus dirinya sendiri
        if ($id == session()->get('user_id')) {
            return redirect()->to('/user')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan!');
        }

        // Cek apakah user yang akan dihapus adalah admin terakhir
        if ($user['role'] == 'admin') {
            $adminCount = $this->userModel->where('role', 'admin')->countAllResults();
            if ($adminCount <= 1) {
                return redirect()->to('/user')->with('error', 'Tidak bisa menghapus admin terakhir!');
            }
        }

        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'User berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus user!');
        }

        return redirect()->to('/user');
    }

    public function changePassword()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'title' => 'Ubah Password'
        ];

        return view('backend/user/change_password', $data);
    }

    public function updatePassword()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $current_password = $this->request->getPost('current_password');
        $new_password = $this->request->getPost('new_password');
        $confirm_password = $this->request->getPost('confirm_password');

        // Validasi password lama
        $user = $this->userModel->find(session()->get('user_id'));
        if (!password_verify($current_password, $user['password'])) {
            session()->setFlashdata('error', 'Password lama tidak sesuai!');
            return redirect()->back();
        }

        // Validasi password baru
        if ($new_password !== $confirm_password) {
            session()->setFlashdata('error', 'Konfirmasi password baru tidak cocok!');
            return redirect()->back();
        }

        // Update password
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        if ($this->userModel->update(session()->get('user_id'), ['password' => $hashedPassword])) {
            session()->setFlashdata('success', 'Password berhasil diubah!');
            return redirect()->to('/dashboard/' . session()->get('role'));
        } else {
            session()->setFlashdata('error', 'Gagal mengubah password!');
            return redirect()->back();
        }
    }

    public function profile()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = $this->userModel->find(session()->get('user_id'));
        $data = [
            'title' => 'Profil Saya',
            'user' => $user
        ];

        return view('backend/user/profile', $data);
    }

    public function updateProfile()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $nama = $this->request->getPost('nama');
        $username = $this->request->getPost('username');

        // Cek username sudah ada atau belum (kecuali user yang sedang diedit)
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser && $existingUser['id'] != session()->get('user_id')) {
            session()->setFlashdata('error', 'Username sudah digunakan!');
            return redirect()->back()->withInput();
        }

        $data = [
            'username' => $username,
            'nama' => $nama
        ];

        if ($this->userModel->update(session()->get('user_id'), $data)) {
            // Update session nama
            session()->set('nama', $nama);
            session()->set('username', $username);
            
            session()->setFlashdata('success', 'Profil berhasil diupdate!');
            return redirect()->to('/user/profile');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate profil!');
            return redirect()->back()->withInput();
        }
    }
} 