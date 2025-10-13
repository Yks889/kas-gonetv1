<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        // Ambil parameter filter dari URL
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        // Query dasar - exclude admin
        $model->where('role !=', 'admin');

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
                'role'     => 'user'
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
        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        helper(['form']);
        $model = new UserModel();
        $user = $model->find($id);

        $rules = [
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username,id,' . $id . ']',
        ];

        if ($this->validate($rules)) {
            $data = [
                'username' => $this->request->getVar('username'),
                'role'     => 'user'
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
        $model->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
