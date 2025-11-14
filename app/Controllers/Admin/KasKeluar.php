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
        $kasKeluarModel->select('kas_keluar.*, pengajuan.status, pengajuan.confirm_at, users.username');
        $kasKeluarModel->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left');
        $kasKeluarModel->join('users', 'users.id = pengajuan.user_id', 'left');

        // 🟦 Ambil filter dari GET
        $month = $this->request->getGet('month');
        $year  = $this->request->getGet('year');
        $search = $this->request->getGet('search');

        // 🔍 Filter pencarian (user, keterangan, status)
        if ($search) {
            $kasKeluarModel->groupStart()
                ->like('users.username', $search)
                ->orLike('kas_keluar.keterangan', $search)
                ->orLike('pengajuan.status', $search)
                ->groupEnd();
        }

        // 📅 Filter bulan dan tahun
        if ($month) {
            $kasKeluarModel->where('MONTH(pengajuan.updated_at)', $month);
        }
        if ($year) {
            $kasKeluarModel->where('YEAR(pengajuan.updated_at)', $year);
        }


        // Urutkan terbaru
        $kasKeluarModel->orderBy('kas_keluar.created_at', 'DESC');
        $data['kas_keluar'] = $kasKeluarModel->findAll();

        // 🔸 Hitung total pengeluaran (yang selesai)
        $totalQuery = clone $kasKeluarModel;
        $data['total_pengeluaran'] = $totalQuery
            ->selectSum('kas_keluar.nominal')
            ->join('pengajuan p', 'p.id = kas_keluar.pengajuan_id', 'left')
            ->where('p.status', 'selesai')
            ->get()
            ->getRow()->nominal ?? 0;

        // 🔸 Total transaksi selesai
        $countSelesai = clone $kasKeluarModel;
        $data['total_selesai'] = $countSelesai
            ->join('pengajuan p2', 'p2.id = kas_keluar.pengajuan_id', 'left')
            ->where('p2.status', 'selesai')
            ->countAllResults();

        // 🔸 Total user unik
        $countUser = clone $kasKeluarModel;
        $data['total_user'] = $countUser
            ->join('pengajuan p3', 'p3.id = kas_keluar.pengajuan_id', 'left')
            ->join('users u3', 'u3.id = p3.user_id', 'left')
            ->distinct()
            ->select('u3.id')
            ->countAllResults();

        $data['title'] = 'Kas Keluar';
        $data['search'] = $search;
        $data['month'] = $month;
        $data['year'] = $year;

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
