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

        // Ringkasan Kas & Pengguna
        $saldo = $kasSaldoModel->first();
        $total_masuk = $kasMasukModel->selectSum('nominal', 'total')->first();
        $total_keluar = $kasKeluarModel->selectSum('nominal', 'total')->first();
        $total_pengajuan = $pengajuanModel->countAll();
        $total_users = $userModel->where('role !=', 'admin')->countAllResults();
        $pengajuan_pending = $pengajuanModel->where('status', 'pending')->countAllResults();
        $pengajuan_ditolak = $pengajuanModel->where('status', 'ditolak')->countAllResults();

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
            'masukData' => array_values($masukData),
            'keluarData' => array_values($keluarData),
            'persentase_pengajuan' => $persentase_pengajuan,
        ];

        return view('admin/dashboard', $data);
    }
}
