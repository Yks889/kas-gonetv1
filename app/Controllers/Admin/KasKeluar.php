<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\ActivityLogModel; 

class KasKeluar extends BaseController
{
    public function index()
    {
        $pengajuanModel = new PengajuanModel();
        // join ke user biar bisa tampil username
        $pengajuanModel->select('pengajuan.*, users.username');
        $pengajuanModel->join('users', 'users.id = pengajuan.user_id', 'left');
        $data['title'] = 'Kas Keluar';
        $data['pengajuan'] = $pengajuanModel->findAll();

        return view('admin/kas_keluar/index', $data);
    }

    public function edit($id)
    {
        $model = new PengajuanModel();
        $data['title'] = 'Edit Kas Keluar';
        $data['pengajuan'] = $model->find($id);

        if (!$data['pengajuan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data dengan ID $id tidak ditemukan");
        }

        return view('admin/kas_keluar/edit', $data);
    }

    public function update($id)
    {
        $model = new PengajuanModel();
        $activityModel = new ActivityLogModel(); // ✅

        $nominal    = $this->request->getVar('nominal');
        $keterangan = $this->request->getVar('keterangan');
        $deadline   = $this->request->getVar('deadline');
        $status     = $this->request->getVar('status');

        $model->update($id, [
            'nominal'    => $nominal,
            'keterangan' => $keterangan,
            'deadline'   => $deadline,
            'status'     => $status,
        ]);

        // ✅ Simpan ke activity log
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'mengupdate kas keluar',
            "Mengubah kas keluar ID {$id} menjadi Rp {$nominal}, status: {$status}, deadline: {$deadline}, keterangan: {$keterangan}"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new PengajuanModel();
        $activityModel = new ActivityLogModel(); // ✅

        $data = $model->find($id); // ambil data lama untuk dicatat
        $model->delete($id);

        // ✅ Simpan ke activity log
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'menghapus kas keluar',
            "Menghapus kas keluar ID {$id} (nominal: Rp {$data['nominal']}, status: {$data['status']}, keterangan: {$data['keterangan']})"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar berhasil dihapus.');
    }
}
