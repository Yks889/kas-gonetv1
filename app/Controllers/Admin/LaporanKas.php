<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasSaldoModel;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\PengajuanModel;

class LaporanKas extends BaseController
{
    public function index()
    {
        $kasSaldoModel = new KasSaldoModel();
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();
        $pengajuanModel = new PengajuanModel();

        // Ambil filter bulan (jika ada) - Untuk Status Pengajuan dan Card
        $bulan = $this->request->getGet('bulan'); // nilai 1-12

        // Saldo kas (TETAP data keseluruhan)
        $saldo = $kasSaldoModel->first();
        $data['saldo_akhir'] = $saldo ? $saldo['saldo_akhir'] : 0;

        // Total Masuk (TETAP data keseluruhan)
        $total_masuk = $kasMasukModel->selectSum('nominal', 'total')->first();
        $data['total_masuk'] = $total_masuk['total'] ?? 0;

        // Total Keluar (TETAP data keseluruhan)
        $total_keluar = $kasKeluarModel->selectSum('nominal', 'total')->first();
        $data['total_keluar'] = $total_keluar['total'] ?? 0;

        // Data yang DIFILTER untuk Card
        $total_masuk_filter = $kasMasukModel;
        $total_keluar_filter = $kasKeluarModel;

        if ($bulan) {
            $total_masuk_filter->where('MONTH(created_at)', $bulan);
            $total_keluar_filter->where('MONTH(created_at)', $bulan);
        }

        $total_masuk_filter = $total_masuk_filter->selectSum('nominal', 'total')->first();
        $data['total_masuk_filter'] = $total_masuk_filter['total'] ?? 0;

        $total_keluar_filter = $total_keluar_filter->selectSum('nominal', 'total')->first();
        $data['total_keluar_filter'] = $total_keluar_filter['total'] ?? 0;

        $data['saldo_bersih_filter'] = $data['total_masuk_filter'] - $data['total_keluar_filter'];

        // Statistik Pengajuan (MENGIKUTI FILTER BULAN)
        $pengajuanQuery = $pengajuanModel;
        if ($bulan) {
            $pengajuanQuery->where('MONTH(created_at)', $bulan);
        }
        $total_pengajuan = $pengajuanQuery->countAllResults(false);

        $pengajuan_pending = $pengajuanModel->where('status', 'pending');
        if ($bulan) {
            $pengajuan_pending->where('MONTH(created_at)', $bulan);
        }
        $pengajuan_pending = $pengajuan_pending->countAllResults();

        $pengajuan_ditolak = $pengajuanModel->where('status', 'ditolak');
        if ($bulan) {
            $pengajuan_ditolak->where('MONTH(created_at)', $bulan);
        }
        $pengajuan_ditolak = $pengajuan_ditolak->countAllResults();

        // Hitung persentase pengajuan selesai
        $pengajuan_selesai = $total_pengajuan - ($pengajuan_pending + $pengajuan_ditolak);
        $data['persentase_pengajuan'] = $total_pengajuan > 0
            ? round(($pengajuan_selesai / $total_pengajuan) * 100)
            : 0;

        $data['pengajuan_pending'] = $pengajuan_pending;
        $data['pengajuan_ditolak'] = $pengajuan_ditolak;
        $data['pengajuan_selesai'] = $pengajuan_selesai;

        // Rekap Bulanan Kas Masuk (TETAP data keseluruhan 12 bulan)
        $monthlyMasuk = $kasMasukModel
            ->select("MONTH(created_at) as bulan, SUM(nominal) as total")
            ->groupBy("MONTH(created_at)")
            ->findAll();

        // Rekap Bulanan Kas Keluar (TETAP data keseluruhan 12 bulan)
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

        $data['bulanLabels'] = $bulanLabels;
        $data['masukData'] = [];
        $data['keluarData'] = [];

        for ($i = 1; $i <= 12; $i++) {
            $data['masukData'][] = $masukData[$i];
            $data['keluarData'][] = $keluarData[$i];
        }

        $data['bulanDipilih'] = $bulan;

        return view('admin/laporan_kas/index', $data);
    }
}