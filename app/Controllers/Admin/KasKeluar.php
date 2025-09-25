<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasKeluarModel;
use App\Models\KasSaldoModel;
use App\Models\ActivityLogModel;

class KasKeluar extends BaseController
{
    public function index()
    {
        $kasKeluarModel = new KasKeluarModel();
        $kasKeluarModel->select('kas_keluar.*, pengajuan.status, pengajuan.deadline, users.username');
        $kasKeluarModel->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left');
        $kasKeluarModel->join('users', 'users.id = pengajuan.user_id', 'left');

        $data['title'] = 'Kas Keluar';
        $data['kas_keluar'] = $kasKeluarModel->findAll();

        return view('admin/kas_keluar/index', $data);
    }

    public function edit($id)
    {
        $pengajuanModel = new PengajuanModel();
        $data['title'] = 'Edit Kas Keluar';
        $data['pengajuan'] = $pengajuanModel->find($id);

        if (!$data['pengajuan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data pengajuan ID $id tidak ditemukan");
        }

        return view('admin/kas_keluar/edit', $data);
    }

    public function update($id)
    {
        $pengajuanModel = new PengajuanModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasSaldoModel  = new KasSaldoModel();
        $activityModel  = new ActivityLogModel();

        $oldData = $pengajuanModel->find($id);
        if (!$oldData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data pengajuan ID $id tidak ditemukan");
        }

        // Pastikan nominal float
        $nominal    = (float) str_replace(',', '', $this->request->getVar('nominal'));
        $keterangan = $this->request->getVar('keterangan');
        $deadline   = $this->request->getVar('deadline');
        $status     = $this->request->getVar('status');

        // Update pengajuan
        $pengajuanModel->update($id, [
            'nominal'    => $nominal,
            'keterangan' => $keterangan,
            'deadline'   => $deadline,
        ]);

        // Sinkronisasi kas_keluar
        $kasKeluarData = $kasKeluarModel->where('pengajuan_id', $id)->findAll();
        if (!empty($kasKeluarData)) {
            foreach ($kasKeluarData as $row) {
                $kasKeluarModel->update($row['id'], [
                    'nominal'    => $nominal,
                    'keterangan' => $keterangan,
                ]);
            }
        } else {
            $kasKeluarModel->insert([
                'pengajuan_id' => $id,
                'nominal'      => $nominal,
                'keterangan'   => $keterangan,
                'created_at'   => date('Y-m-d H:i:s')
            ]);
        }

        // Update saldo (selisih nominal)
        $saldo = $kasSaldoModel->first();
        if ($saldo) {
            $oldSaldo = (float) $saldo['saldo_akhir'];
            $oldNominal = (float) ($oldData['nominal'] ?? 0);
            $newSaldo = $oldSaldo + $oldNominal - $nominal;

            $kasSaldoModel->save([
                'id' => $saldo['id'],
                'saldo_akhir' => $newSaldo
            ]);
        }

        // Log aktivitas
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'update_kas_keluar',
            "Mengubah kas keluar & pengajuan ID {$id} dari Rp {$oldData['nominal']} menjadi Rp {$nominal}, status: {$status}, deadline: {$deadline}, keterangan: {$keterangan}"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar & pengajuan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pengajuanModel = new PengajuanModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasSaldoModel  = new KasSaldoModel();
        $activityModel  = new ActivityLogModel();

        $data = $pengajuanModel->find($id);
        if (!$data) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data pengajuan ID $id tidak ditemukan");
        }

        // Hapus kas_keluar terkait
        $kasKeluarModel->where('pengajuan_id', $id)->delete();

        // Hapus pengajuan
        $pengajuanModel->delete($id);

        // Kembalikan saldo sesuai nominal
        $saldo = $kasSaldoModel->first();
        if ($saldo) {
            $oldSaldo = (float) $saldo['saldo_akhir'];
            $nominal = (float) ($data['nominal'] ?? 0);
            $newSaldo = $oldSaldo + $nominal;

            $kasSaldoModel->save([
                'id' => $saldo['id'],
                'saldo_akhir' => $newSaldo
            ]);
        }

        // Log aktivitas
        $session = session();
        $activityModel->logActivity(
            $session->get('id'),
            'delete_kas_keluar',
            "Menghapus kas keluar & pengajuan ID {$id} (nominal: Rp {$data['nominal']}, status: {$data['status']}, keterangan: {$data['keterangan']})"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar & pengajuan berhasil dihapus.');
    }

    public function insert()
    {
        $pengajuanModel = new PengajuanModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasSaldoModel  = new KasSaldoModel();
        $activityModel  = new ActivityLogModel();

        // Pastikan nominal float
        $nominal    = (float) str_replace(',', '', $this->request->getVar('nominal'));
        $keterangan = $this->request->getVar('keterangan');
        $deadline   = $this->request->getVar('deadline');
        $userId     = session()->get('id');

        // Insert pengajuan
        $pengajuanId = $pengajuanModel->insert([
            'user_id'    => $userId,
            'nominal'    => $nominal,
            'keterangan' => $keterangan,
            'deadline'   => $deadline,
            'status'     => 'selesai',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Insert kas keluar
        $kasKeluarModel->insert([
            'pengajuan_id' => $pengajuanId,
            'nominal'      => $nominal,
            'keterangan'   => $keterangan,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        // Kurangi saldo utama
        $saldo = $kasSaldoModel->first();
        if ($saldo) {
            $oldSaldo = (float) $saldo['saldo_akhir'];
            $newSaldo = $oldSaldo - $nominal;

            $kasSaldoModel->save([
                'id' => $saldo['id'],
                'saldo_akhir' => $newSaldo
            ]);
        }

        // Log aktivitas
        $activityModel->logActivity(
            $userId,
            'insert_kas_keluar',
            "Menambahkan kas keluar baru (nominal: Rp {$nominal}, keterangan: {$keterangan}, deadline: {$deadline})"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar berhasil ditambahkan.');
    }
}
