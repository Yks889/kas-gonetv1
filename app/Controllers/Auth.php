<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ActivityLogModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        helper(['form']);
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UserModel();
        $logModel = new ActivityLogModel();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            // Cek apakah akun aktif
            if ($user['is_active'] == 0) {
                $session->setFlashdata('error', 'Akun Anda belum dikonfirmasi admin. Silakan tunggu hingga akun diaktifkan.');
                return redirect()->to('/login');
            }

            if (password_verify($password, $user['password'])) {
                $ses_data = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);

                // ✅ Catat aktivitas login
                $logModel->logActivity($user['id'], 'login', 'User berhasil login');

                // Set flashdata untuk login berhasil
                $session->setFlashdata('login_success', true);
                $session->setFlashdata('redirect_url', $user['role'] == 'admin' ? '/admin/dashboard' : '/user/dashboard');

                return redirect()->to('/login');
            } else {
                $session->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function attemptRegister()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[6]|max_length[200]',
            'confpassword' => 'matches[password]'
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role' => 'user',
                'is_active' => 0
            ];
            $model->save($data);

            // Set flashdata success
            session()->setFlashdata('success', 'Registrasi berhasil. Akun Anda menunggu konfirmasi admin.');
            return redirect()->to('/login');
        } else {
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }
    }

    public function logout()
    {
        $session = session();
        $userId = $session->get('id');
        $logModel = new ActivityLogModel();

        if ($userId) {
            $logModel->logActivity($userId, 'logout', 'User logout dari sistem');
        }

        $session->destroy();
        return redirect()->to('/login');
    }
}
