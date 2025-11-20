<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PengajuanModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        // Ambil parameter filter dari URL
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        // Query dasar - exclude admin dan hanya tampilkan yang tidak terhapus
        $model->where('role !=', 'admin');
        $model->where('deleted_at IS NULL'); // Hanya tampilkan data yang tidak dihapus

        // Filter berdasarkan bulan
        if (!empty($month) && is_numeric($month) && $month >= 1 && $month <= 12) {
            $model->where('MONTH(created_at)', $month);
        }

        // Filter berdasarkan tahun
        if (!empty($year) && is_numeric($year)) {
            $model->where('YEAR(created_at)', $year);
        }

        // Urutkan berdasarkan yang terbaru
        $model->orderBy('created_at', 'DESC');

        $data['users'] = $model->findAll();

        // Pass filter values ke view untuk menjaga state form
        $data['current_filters'] = [
            'month' => $month,
            'year' => $year
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        helper(['form']);
        return view('admin/users/create');
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
            'password' => 'required|min_length[6]|max_length[200]',
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'username' => $this->request->getVar('username'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'role'     => 'user',
                'is_active' => 1 // user yang dibuat admin langsung aktif
            ];

            $model->save($data);
            return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan.');
        } else {
            return view('admin/users/create', [
                'validation' => $this->validator
            ]);
        }
    }

    public function edit($id)
    {
        helper(['form']);
        $model = new UserModel();
        $data['user'] = $model->find($id);

        if (!$data['user'] || $data['user']['deleted_at'] !== null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $model = new UserModel();
        $user = $model->find($id);

        // Cek jika user tidak ditemukan atau sudah dihapus
        if (!$user || $user['deleted_at'] !== null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username,id,' . $id . ']',
        ];

        if ($this->validate($rules)) {
            $data = [
                'username' => $this->request->getVar('username'),
                'role'     => $this->request->getVar('role') ?? 'user',
                'is_active' => $this->request->getVar('is_active') ?? 1
            ];

            if ($this->request->getVar('password')) {
                $data['password'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
            }

            $model->update($id, $data);
            return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate.');
        } else {
            $data['user'] = $user;
            $data['validation'] = $this->validator;
            return view('admin/users/edit', $data);
        }
    }

    public function delete($id)
    {
        $model = new UserModel();
        $pengajuanModel = new PengajuanModel();

        // Cek jika user ada dan belum dihapus
        $user = $model->find($id);
        if (!$user || $user['deleted_at'] !== null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        // Soft delete user (set deleted_at DAN nonaktifkan akun)
        $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'is_active' => 0 // Nonaktifkan akun agar tidak bisa login
        ]);

        // Soft delete semua pengajuan user tersebut
        $pengajuanModel->where('user_id', $id)
            ->set(['deleted_at' => date('Y-m-d H:i:s')])
            ->update();

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus, dinonaktifkan, dan semua pengajuannya diarsipkan.');
    }

    public function activate($id)
    {
        $model = new UserModel();

        // Cek jika user ada dan belum dihapus
        $user = $model->find($id);
        if (!$user || $user['deleted_at'] !== null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        $model->update($id, ['is_active' => 1]);

        return redirect()->to('/admin/users')->with('success', 'Akun berhasil diaktifkan.');
    }

    public function deactivate($id)
    {
        $model = new UserModel();

        // Cek jika user ada dan belum dihapus
        $user = $model->find($id);
        if (!$user || $user['deleted_at'] !== null) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        $model->update($id, ['is_active' => 0]);

        return redirect()->to('/admin/users')->with('success', 'Akun berhasil dinonaktifkan.');
    }

    public function bulkActivate()
    {
        // Check if it's AJAX request
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON(['success' => false, 'message' => 'Method not allowed']);
        }

        $userIds = json_decode($this->request->getPost('user_ids'), true);

        if (empty($userIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No users selected']);
        }

        try {
            // Update status user menjadi aktif
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->whereIn('id', $userIds)
                ->where('deleted_at IS NULL') // Hanya update yang belum dihapus
                ->set(['is_active' => 1])
                ->update();

            return $this->response->setJSON(['success' => true, 'message' => 'Users activated successfully']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function bulkDelete()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }

        $userIds = json_decode($this->request->getPost('user_ids'), true);

        if (empty($userIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No users selected'
            ]);
        }

        try {
            $model = new UserModel();
            $pengajuanModel = new PengajuanModel();
            $db = \Config\Database::connect();

            // Soft delete users - set deleted_at DAN nonaktifkan akun
            $builder = $db->table('users');
            $builder->whereIn('id', $userIds)
                ->where('deleted_at IS NULL') // Hanya yang belum dihapus
                ->set([
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'is_active' => 0 // Nonaktifkan semua akun yang dihapus
                ])
                ->update();

            // Soft delete semua pengajuan dari user yang dihapus
            $pengajuanBuilder = $db->table('pengajuan');
            $pengajuanBuilder->whereIn('user_id', $userIds)
                ->where('deleted_at IS NULL')
                ->set(['deleted_at' => date('Y-m-d H:i:s')])
                ->update();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Users soft-deleted, deactivated, and all their submissions archived successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Tambahan: Fungsi untuk restore user yang dihapus
    public function restore($id)
    {
        $model = new UserModel();
        $pengajuanModel = new PengajuanModel();
        $db = \Config\Database::connect();

        // Restore user
        $builder = $db->table('users');
        $builder->where('id', $id)
            ->set([
                'deleted_at' => null,
                'is_active' => 1 // Aktifkan kembali akun saat restore
            ])
            ->update();

        // Restore semua pengajuan user tersebut
        $pengajuanBuilder = $db->table('pengajuan');
        $pengajuanBuilder->where('user_id', $id)
            ->set(['deleted_at' => null])
            ->update();

        return redirect()->to('/admin/users')->with('success', 'User berhasil dipulihkan, diaktifkan, dan semua pengajuannya direstore.');
    }
}
