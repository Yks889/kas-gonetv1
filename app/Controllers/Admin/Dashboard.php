<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasSaldoModel;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\PengajuanModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $kasSaldoModel = new KasSaldoModel();
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();
        $pengajuanModel = new PengajuanModel();
        $userModel = new UserModel();

        // Ambil filter bulan (jika ada)
        $bulan = $this->request->getGet('bulan'); // nilai 1-12

        // Ringkasan Kas & Pengguna
        $saldo = $kasSaldoModel->first();

        // Total Masuk
        $kasMasukQuery = $kasMasukModel->selectSum('nominal', 'total');
        if ($bulan) {
            $kasMasukQuery->where('MONTH(created_at)', $bulan);
        }
        $total_masuk = $kasMasukQuery->first();

        // Total Keluar
        $kasKeluarQuery = $kasKeluarModel->selectSum('nominal', 'total');
        if ($bulan) {
            $kasKeluarQuery->where('MONTH(created_at)', $bulan);
        }
        $total_keluar = $kasKeluarQuery->first();

        // Pengajuan
        $pengajuanQuery = $pengajuanModel;
        if ($bulan) {
            $pengajuanQuery->where('MONTH(created_at)', $bulan);
        }
        $total_pengajuan = $pengajuanQuery->countAllResults(false);

        $total_users = $userModel->where('role !=', 'admin')->countAllResults();

        $pengajuan_pending = $pengajuanModel->where('status', 'pending')
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->countAllResults();

        $pengajuan_ditolak = $pengajuanModel->where('status', 'ditolak')
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->countAllResults();

        // Data untuk tabs - DIPERBAIKI
        $pengajuan = $pengajuanModel
            ->select('pengajuan.*, users.username')
            ->join('users', 'users.id = pengajuan.user_id')
            ->when($bulan, fn($q) => $q->where('MONTH(pengajuan.created_at)', $bulan))
            ->orderBy('pengajuan.created_at', 'DESC')
            ->findAll(10); // Limit to 10 records

        $kas_masuk = $kasMasukModel
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->orderBy('created_at', 'DESC')
            ->findAll(10);

        // QUERY KAS KELUAR DIPERBAIKI
        $kas_keluar = $kasKeluarModel
            ->select('kas_keluar.*, pengajuan.user_id, users.username, pengajuan.keterangan as pengajuan_keterangan')
            ->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left')
            ->join('users', 'users.id = pengajuan.user_id', 'left')
            ->when($bulan, fn($q) => $q->where('MONTH(kas_keluar.created_at)', $bulan))
            ->orderBy('kas_keluar.created_at', 'DESC')
            ->findAll(10);

        // Jika masih error, gunakan query yang lebih sederhana:
        // $kas_keluar = $kasKeluarModel
        //     ->select('kas_keluar.*, pengajuan.keterangan as pengajuan_keterangan')
        //     ->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left')
        //     ->when($bulan, fn($q) => $q->where('MONTH(kas_keluar.created_at)', $bulan))
        //     ->orderBy('kas_keluar.created_at', 'DESC')
        //     ->findAll(10);

        // Hitung jumlah untuk ringkasan
        $kas_masuk_count = $kasMasukModel
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->countAllResults();

        $kas_keluar_count = $kasKeluarModel
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->countAllResults();

        // Kas Masuk & Keluar (filter bulan kalau ada)
        if ($bulan) {
            $total_masuk = $kasMasukModel
                ->selectSum('nominal', 'total')
                ->where('MONTH(created_at)', $bulan)
                ->first();

            $total_keluar = $kasKeluarModel
                ->selectSum('nominal', 'total')
                ->where('MONTH(created_at)', $bulan)
                ->first();
        } else {
            $total_masuk = $kasMasukModel->selectSum('nominal', 'total')->first();
            $total_keluar = $kasKeluarModel->selectSum('nominal', 'total')->first();
        }

        // Statistik Pengajuan (terfilter bulan kalau dipilih)
        if ($bulan) {
            $total_pengajuan = $pengajuanModel
                ->where('MONTH(created_at)', $bulan)
                ->countAllResults();

            $pengajuan_pending = $pengajuanModel
                ->where('MONTH(created_at)', $bulan)
                ->where('status', 'pending')
                ->countAllResults();

            $pengajuan_ditolak = $pengajuanModel
                ->where('MONTH(created_at)', $bulan)
                ->where('status', 'ditolak')
                ->countAllResults();
        } else {
            $total_pengajuan = $pengajuanModel->countAll();
            $pengajuan_pending = $pengajuanModel->where('status', 'pending')->countAllResults();
            $pengajuan_ditolak = $pengajuanModel->where('status', 'ditolak')->countAllResults();
        }

        // User tetap total semua
        $total_users = $userModel->where('role !=', 'admin')->countAllResults();

        // Hitung persentase pengajuan selesai
        $pengajuan_selesai = $total_pengajuan - ($pengajuan_pending + $pengajuan_ditolak);
        $persentase_pengajuan = $total_pengajuan > 0
            ? round(($pengajuan_selesai / $total_pengajuan) * 100)
            : 0;

        // Rekap Bulanan Kas Masuk
        $monthlyMasuk = $kasMasukModel
            ->select("MONTH(created_at) as bulan, SUM(nominal) as total")
            ->groupBy("MONTH(created_at)")
            ->findAll();

        // Rekap Bulanan Kas Keluar
        $monthlyKeluar = $kasKeluarModel
            ->select("MONTH(created_at) as bulan, SUM(nominal) as total")
            ->groupBy("MONTH(created_at)")
            ->findAll();

        // Susun data 12 bulan (Jan–Des)
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $masukData = array_fill(1, 12, 0);
        foreach ($monthlyMasuk as $row) {
            $masukData[(int) $row['bulan']] = (float) $row['total'];
        }

        $keluarData = array_fill(1, 12, 0);
        foreach ($monthlyKeluar as $row) {
            $keluarData[(int) $row['bulan']] = (float) $row['total'];
        }

        $masukDataFinal = [];
        $keluarDataFinal = [];
        for ($i = 1; $i <= 12; $i++) {
            $masukDataFinal[] = $masukData[$i];
            $keluarDataFinal[] = $keluarData[$i];
        }

        // Data untuk dikirim ke view
        $data = [
            'saldo' => $saldo,
            'total_masuk' => $total_masuk,
            'total_keluar' => $total_keluar,
            'total_pengajuan' => $total_pengajuan,
            'total_users' => $total_users,
            'pengajuan_pending' => $pengajuan_pending,
            'pengajuan_ditolak' => $pengajuan_ditolak,
            'bulanLabels' => $bulanLabels,
            'masukData' => $masukDataFinal,
            'keluarData' => $keluarDataFinal,
            'persentase_pengajuan' => $persentase_pengajuan,
            'bulanDipilih' => $bulan,
            'pengajuan' => $pengajuan,
            'kas_masuk' => $kas_masuk,
            'kas_keluar' => $kas_keluar,
            'kas_masuk_count' => $kas_masuk_count,
            'kas_keluar_count' => $kas_keluar_count
        ];

        return view('admin/dashboard', $data);
    }
}