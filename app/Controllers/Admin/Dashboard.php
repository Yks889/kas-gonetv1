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

        // Ambil parameter filter bulan dari GET
        $filterBulan = $this->request->getGet('bulan');

        // Ringkasan Kas & Pengguna
        $saldo = $kasSaldoModel->first();

        // Kas Masuk & Keluar (filter bulan kalau ada)
        if ($filterBulan) {
            $total_masuk = $kasMasukModel
                ->selectSum('nominal', 'total')
                ->where('MONTH(created_at)', $filterBulan)
                ->first();

            $total_keluar = $kasKeluarModel
                ->selectSum('nominal', 'total')
                ->where('MONTH(created_at)', $filterBulan)
                ->first();
        } else {
            $total_masuk = $kasMasukModel->selectSum('nominal', 'total')->first();
            $total_keluar = $kasKeluarModel->selectSum('nominal', 'total')->first();
        }

        // Statistik Pengajuan (terfilter bulan kalau dipilih)
        if ($filterBulan) {
            $total_pengajuan = $pengajuanModel
                ->where('MONTH(created_at)', $filterBulan)
                ->countAllResults();

            $pengajuan_pending = $pengajuanModel
                ->where('MONTH(created_at)', $filterBulan)
                ->where('status', 'pending')
                ->countAllResults();

            $pengajuan_ditolak = $pengajuanModel
                ->where('MONTH(created_at)', $filterBulan)
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
            'filterBulan' => $filterBulan, // untuk form select di view
        ];

        return view('admin/dashboard', $data);
    }
}
