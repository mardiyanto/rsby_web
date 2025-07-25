<?php
namespace App\Controllers;
use App\Models\AuthModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login/index');
    }

    public function doLogin()
    {
        $session = session();
        $model = new AuthModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'nama' => $user['nama'],
                'logged_in' => true
            ]);
            // Redirect sesuai role
            if ($user['role'] == 'admin') {
                return redirect()->to('/dashboard/admin');
            } elseif ($user['role'] == 'user') {
                return redirect()->to('/dashboard/user');
            }
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
