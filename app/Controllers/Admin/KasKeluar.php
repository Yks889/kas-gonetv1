<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasKeluarModel;
use App\Models\KasSaldoModel;
use App\Models\ActivityLogModel;
use App\Models\UserModel;


class KasKeluar extends BaseController
{
    public function index()
    {
        $kasKeluarModel = new KasKeluarModel();
        $userModel = new UserModel();
        $pengajuanModel = new PengajuanModel();

        $kasKeluarModel
            ->withDeleted() // <--- WAJIB supaya join tidak hilang ketika soft delete
            ->select('kas_keluar.*, p.status, p.confirm_at, u.username')
            ->join('pengajuan p', 'p.id = kas_keluar.pengajuan_id', 'left')
            ->join('users u', 'u.id = p.user_id', 'left');


        $kasKeluarModel->withDeleted();

        // Filter
        $month  = $this->request->getGet('month');
        $year   = $this->request->getGet('year');
        $search = $this->request->getGet('search');

        if ($search) {
            $kasKeluarModel->groupStart()
                ->like('u.username', $search)
                ->orLike('kas_keluar.keterangan', $search)
                ->orLike('p.status', $search)
                ->groupEnd();
        }

        if ($month) {
            $kasKeluarModel->where('MONTH(kas_keluar.created_at)', $month);
        }
        if ($year) {
            $kasKeluarModel->where('YEAR(kas_keluar.created_at)', $year);
        }

        $kasKeluarModel->orderBy('kas_keluar.created_at', 'DESC');

        $data['kas_keluar'] = $kasKeluarModel->findAll();
        $data['title'] = 'Kas Keluar';
        $data['search'] = $search;
        $data['month']  = $month;
        $data['year']   = $year;

        // Total Pengeluaran (semua kas keluar yang sudah selesai)
        $totalPengeluaranQuery = $kasKeluarModel
            ->withDeleted()
            ->selectSum('kas_keluar.nominal')
            ->join('pengajuan p', 'p.id = kas_keluar.pengajuan_id')
            ->where('p.status', 'selesai');

        // Apply filter yang sama untuk total pengeluaran
        if ($month) {
            $totalPengeluaranQuery->where('MONTH(kas_keluar.created_at)', $month);
        }
        if ($year) {
            $totalPengeluaranQuery->where('YEAR(kas_keluar.created_at)', $year);
        }

        $data['total_pengeluaran'] = $totalPengeluaranQuery->get()
            ->getRow()
            ->nominal ?? 0;

        // Total Data Selesai (pengajuan dengan status selesai)
        $totalSelesaiQuery = $kasKeluarModel
            ->join('pengajuan p', 'p.id = kas_keluar.pengajuan_id')
            ->where('p.status', 'selesai');

        // Apply filter yang sama untuk total selesai
        if ($month) {
            $totalSelesaiQuery->where('MONTH(created_at)', $month);
        }
        if ($year) {
            $totalSelesaiQuery->where('YEAR(created_at)', $year);
        }

        $data['total_selesai'] = $totalSelesaiQuery->countAllResults();

        // Total User Mengajukan (user unik yang memiliki pengajuan selesai)
        $totalUserQuery = $userModel
            ->select('users.id')
            ->join('pengajuan', 'pengajuan.user_id = users.id')
            ->where('pengajuan.status', 'selesai')
            ->distinct();

        // Apply filter yang sama untuk total user
        if ($month) {
            $totalUserQuery->where('MONTH(pengajuan.created_at)', $month);
        }
        if ($year) {
            $totalUserQuery->where('YEAR(pengajuan.created_at)', $year);
        }

        $data['total_user'] = $totalUserQuery->countAllResults();

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
        $tanggal    = $this->request->getVar('confirm_at');
        $status     = $this->request->getVar('status');

        // Update pengajuan
        $pengajuanModel->update($id, [
            'nominal'    => $nominal,
            'keterangan' => $keterangan,
            'updated_at' => date('Y-m-d H:i:s') // 🕒 perbarui waktu diterima
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
            "Mengubah kas keluar & pengajuan ID {$id} dari Rp {$oldData['nominal']} menjadi Rp {$nominal}, status: {$status}, deadline: {$tanggal}, keterangan: {$keterangan}"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar & pengajuan berhasil diperbarui.');
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
        $tanggal = $this->request->getVar('confirm_at');
        $userId     = session()->get('id');

        // Insert pengajuan
        $pengajuanId = $pengajuanModel->insert([
            'user_id'    => $userId,
            'nominal'    => $nominal,
            'keterangan' => $keterangan,
            'status'     => 'selesai',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'confirm_at' => date('Y-m-d H:i:s') // ✅ tambahkan ini
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
            "Menambahkan kas keluar baru (nominal: Rp {$nominal}, keterangan: {$keterangan}, deadline: {$tanggal})"
        );

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar berhasil ditambahkan.');
    }
}
