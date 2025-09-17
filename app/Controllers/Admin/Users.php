<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->where('role !=', 'admin')->findAll();
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
                // lebih aman pake hash password
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
            'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username,id,'.$id.']',
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
