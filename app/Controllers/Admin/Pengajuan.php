<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasKeluarModel;
use App\Models\KasSaldoModel;
use App\Models\NotificationModel;
use App\Models\ActivityLogModel;

class Pengajuan extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();
        $model->select('pengajuan.*, users.username, kas_keluar.file_nota');
        $model->join('users', 'users.id = pengajuan.user_id');
        $model->join('kas_keluar', 'kas_keluar.pengajuan_id = pengajuan.id', 'left');
        $data['pengajuan'] = $model->findAll();

        return view('admin/pengajuan/index', $data);
    }

    public function approve($id)
    {
        $session = session();
        $model = new PengajuanModel();
        $model->update($id, ['status' => 'diterima']);

        $pengajuan = $model->find($id);

        // Simpan notifikasi
        $notifModel = new NotificationModel();
        $notifModel->save([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda telah disetujui.'
        ]);

        // Simpan aktivitas log
        $activityLog = new ActivityLogModel();
        $activityLog->logActivity(
            $session->get('id'),
            'pengajuan diterima',
            'Menyetujui pengajuan ID ' . $id
        );

        return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject($id)
    {
        $session = session();
        $model = new PengajuanModel();
        $model->update($id, ['status' => 'ditolak']);

        $pengajuan = $model->find($id);

        // Simpan notifikasi
        $notifModel = new NotificationModel();
        $notifModel->save([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda ditolak.'
        ]);

        // Simpan aktivitas log
        $activityLog = new ActivityLogModel();
        $activityLog->logActivity(
            $session->get('id'),
            'pengajuan ditolak',
            'Menolak pengajuan ID ' . $id
        );

        return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function process($id)
    {
        $session = session();
        $pengajuanModel = new PengajuanModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasSaldoModel  = new KasSaldoModel();
        $activityLog    = new ActivityLogModel();

        $pengajuan = $pengajuanModel->find($id);
        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
        }

        $kasKeluar = $kasKeluarModel->where('pengajuan_id', $id)->first();
        $metode    = $pengajuan['tipe']; // uang_sendiri / minta_uang

        // ============================
        // Metode: UANG SENDIRI
        // ============================
        if ($metode === 'uang_sendiri') {
            if (!$kasKeluar) {
                $kasKeluarModel->save([
                    'pengajuan_id' => $id,
                    'nominal'      => $pengajuan['nominal'],
                    'keterangan'   => $pengajuan['keterangan'],
                    'file_nota'    => null
                ]);
            }

            // Potong saldo (selalu)
            $saldo = $kasSaldoModel->first();
            if ($saldo) {
                $newSaldo = $saldo['saldo_akhir'] - $pengajuan['nominal'];
                $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
            }

            $pengajuanModel->update($id, ['status' => 'selesai']);

            $activityLog->logActivity(
                $session->get('id'),
                'pengajuan diproses',
                'Memproses pengajuan uang sendiri ID ' . $id
            );

            return redirect()->back()->with('success', 'Pengajuan diproses & saldo dipotong (uang sendiri).');
        }

        // ============================
        // Metode: MINTA UANG
        // ============================
        if ($metode === 'minta_uang') {

            // Kas keluar sudah ada & file nota tersedia → langsung potong saldo
            if ($kasKeluar && !empty($kasKeluar['file_nota'])) {
                $saldo = $kasSaldoModel->first();
                if ($saldo) {
                    $newSaldo = $saldo['saldo_akhir'] - $pengajuan['nominal'];
                    $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
                }

                $pengajuanModel->update($id, ['status' => 'selesai']);

                // Log aktivitas
                $activityLog->logActivity(
                    $session->get('id'),
                    'pengajuan diproses',
                    'Memproses pengajuan minta_uang ID ' . $id . ' (nota sudah ada)'
                );

                return redirect()->back()->with('success', 'Pengajuan selesai & saldo dipotong (minta uang).');
            }

            // Belum ada file nota → wajib upload
            helper(['form']);
            $rules = [
                'file_nota' => 'uploaded[file_nota]|max_size[file_nota,1024]|ext_in[file_nota,jpg,jpeg,png,pdf]'
            ];

            if ($this->validate($rules)) {
                $file = $this->request->getFile('file_nota');
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/nota', $newName);

                    $kasKeluarModel->save([
                        'pengajuan_id' => $id,
                        'nominal'      => $pengajuan['nominal'],
                        'keterangan'   => $pengajuan['keterangan'],
                        'file_nota'    => $newName
                    ]);

                    // Potong saldo
                    $saldo = $kasSaldoModel->first();
                    if ($saldo) {
                        $newSaldo = $saldo['saldo_akhir'] - $pengajuan['nominal'];
                        $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
                    }

                    $pengajuanModel->update($id, ['status' => 'selesai']);

                    // Log aktivitas
                    $activityLog->logActivity(
                        $session->get('id'),
                        'pengajuan diproses',
                        'Memproses pengajuan minta_uang ID ' . $id . ' dengan upload nota'
                    );

                    return redirect()->back()->with('success', 'Pengajuan selesai dengan upload nota & saldo dipotong.');
                }
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: file nota wajib diupload.');
        }

        return redirect()->back()->with('warning', 'Pengajuan masih dalam proses, tunggu nota untuk potong saldo.');
    }
}
