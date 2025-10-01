<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\KasSaldoModel;

class InformasiKas extends BaseController
{
    public function index()
    {
        $pengajuanModel = new PengajuanModel();
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasSaldoModel = new KasSaldoModel();

        // Data pengajuan
        $data['pengajuan'] = $pengajuanModel
            ->select('pengajuan.*, users.username')
            ->join('users', 'users.id = pengajuan.user_id')
            ->orderBy('pengajuan.created_at', 'DESC')
            ->findAll();

        // Data kas masuk
        $data['kas_masuk'] = $kasMasukModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Data kas keluar
        $data['kas_keluar'] = $kasKeluarModel
            ->select('kas_keluar.*, pengajuan.keterangan as pengajuan_keterangan, users.username')
            ->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left')
            ->join('users', 'users.id = pengajuan.user_id', 'left')
            ->orderBy('kas_keluar.created_at', 'DESC')
            ->findAll();

        // Saldo kas
        $saldo = $kasSaldoModel->first();
        $data['saldo_akhir'] = $saldo ? $saldo['saldo_akhir'] : 0;

        // Hitung total kas masuk dan keluar
        $data['total_masuk'] = array_sum(array_column($data['kas_masuk'], 'nominal'));
        $data['total_keluar'] = array_sum(array_column($data['kas_keluar'], 'nominal'));

        return view('admin/informasi_kas/index', $data);
    }
}