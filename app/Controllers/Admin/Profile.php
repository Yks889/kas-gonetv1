<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Profile extends BaseController
{
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->logModel = new ActivityLogModel();
    }

    public function index()
    {
        $user = $this->userModel->find(session()->get('id'));

        return view('admin/profile/index', [
            'user' => $user,
            'title' => 'Profil Pengguna'
        ]);
    }

    public function update()
    {
        $userId = session()->get('id');

        $rules = [
            'username' => "required|min_length[3]|max_length[20]|is_unique[users.username,id,{$userId}]",
            'full_name' => 'permit_empty|min_length[2]|max_length[100]',
            'email' => 'permit_empty|valid_email|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email')
        ];

        $this->userModel->update($userId, $data);

        // Update session username jika berubah
        if (session()->get('username') != $data['username']) {
            session()->set('username', $data['username']);
        }

        // Log aktivitas
        $this->logModel->logActivity($userId, 'update_profile', 'User memperbarui profil');

        return redirect()->to('/admin/profile')->with('message', 'Profil berhasil diperbarui');
    }

    public function updatePassword()
    {
        $userId = session()->get('id');

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $user = $this->userModel->find($userId);
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Verifikasi password saat ini
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah');
        }

        // Update password
        $this->userModel->update($userId, ['password' => $newPassword]);

        // Log aktivitas
        $this->logModel->logActivity($userId, 'change_password', 'User mengubah password');

        return redirect()->to('/admin/profile')->with('message', 'Password berhasil diubah');
    }

    public function updatePhoto()
    {
        $userId = session()->get('id');

        $rules = [
            'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $photo = $this->request->getFile('photo');

        if ($photo->isValid() && !$photo->hasMoved()) {
            // Generate nama file unik
            $newName = $photo->getRandomName();

            // Pindahkan file ke folder uploads/profiles
            $photo->move(ROOTPATH . 'public/uploads/profiles', $newName);

            // Update database
            $this->userModel->update($userId, ['photo' => $newName]);

            // Log aktivitas
            $this->logModel->logActivity($userId, 'update_photo', 'User mengubah foto profil');

            return redirect()->to('/admin/profile')->with('message', 'Foto profil berhasil diunggah');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah foto profil');
    }

    public function removePhoto()
    {
        $userId = session()->get('id');

        $user = $this->userModel->find($userId);

        if ($user['photo']) {
            // Hapus file foto
            $photoPath = ROOTPATH . 'public/uploads/profiles/' . $user['photo'];
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            // Update database
            $this->userModel->update($userId, ['photo' => null]);

            // Log aktivitas
            $this->logModel->logActivity($userId, 'remove_photo', 'User menghapus foto profil');

            return redirect()->to('/admin/profile')->with('message', 'Foto profil berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Tidak ada foto profil untuk dihapus');
    }
}