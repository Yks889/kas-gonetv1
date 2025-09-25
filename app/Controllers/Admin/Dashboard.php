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

        // Hitung persentase pengajuan selesai (disetujui)
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
            'bulanDipilih' => $bulan
        ];

        return view('admin/dashboard', $data);
    }
}
