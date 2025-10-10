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

        // FILTER FUNCTIONALITY
        $filters = $this->request->getGet();

        // Filter by status
        if (!empty($filters['status'])) {
            $model->where('pengajuan.status', $filters['status']);
        }

        // Filter by tipe
        if (!empty($filters['tipe'])) {
            $model->where('pengajuan.tipe', $filters['tipe']);
        }

        // Filter by bulan dan tahun
        if (!empty($filters['month']) || !empty($filters['year'])) {
            if (!empty($filters['month']) && !empty($filters['year'])) {
                // Filter by bulan dan tahun spesifik
                $firstDay = date('Y-m-01', strtotime($filters['year'] . '-' . $filters['month'] . '-01'));
                $lastDay = date('Y-m-t', strtotime($firstDay));
                $model->where("DATE(pengajuan.created_at) BETWEEN '$firstDay' AND '$lastDay'");
            } elseif (!empty($filters['year'])) {
                // Filter by tahun saja
                $model->where('YEAR(pengajuan.created_at)', $filters['year']);
            } elseif (!empty($filters['month'])) {
                // Filter by bulan saja (tahun berjalan)
                $currentYear = date('Y');
                $firstDay = date('Y-m-01', strtotime($currentYear . '-' . $filters['month'] . '-01'));
                $lastDay = date('Y-m-t', strtotime($firstDay));
                $model->where("DATE(pengajuan.created_at) BETWEEN '$firstDay' AND '$lastDay'");
            }
        }

        // Order by created_at descending (pengajuan terbaru di atas)
        $model->orderBy('pengajuan.created_at', 'DESC');

        $data['pengajuan'] = $model->findAll();

        // Ambil saldo kas saat ini untuk validasi di frontend
        $kasSaldoModel = new KasSaldoModel();
        $saldo = $kasSaldoModel->first();
        $data['saldo_akhir'] = $saldo ? $saldo['saldo_akhir'] : 0;

        // Pass filter values to view untuk menjaga state filter
        $data['current_filters'] = [
            'status' => $filters['status'] ?? '',
            'tipe' => $filters['tipe'] ?? '',
            'month' => $filters['month'] ?? '',
            'year' => $filters['year'] ?? ''
        ];

        return view('admin/pengajuan/index', $data);
    }

    public function approve($id)
    {
        $session = session();
        $model = new PengajuanModel();
        $pengajuan = $model->find($id);

        if (!$pengajuan) {
            return redirect()->to('/admin/pengajuan')->with('error', 'Data pengajuan tidak ditemukan.');
        }

        // Validasi saldo di backend juga untuk keamanan
        $kasSaldoModel = new KasSaldoModel();
        $saldo = $kasSaldoModel->first();

        if ($saldo && $pengajuan['nominal'] > $saldo['saldo_akhir']) {
            return redirect()->to('/admin/pengajuan')->with('error', 'Saldo tidak mencukupi untuk menyetujui pengajuan ini.');
        }

        $model->update($id, ['status' => 'diterima']);

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

        // Validasi saldo di backend
        $saldo = $kasSaldoModel->first();
        if ($saldo && $pengajuan['nominal'] > $saldo['saldo_akhir']) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk memproses pengajuan ini.');
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
