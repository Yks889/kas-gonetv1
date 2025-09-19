<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasSaldoModel;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\PengajuanModel;
use App\Models\UserModel;
use App\Models\ActivityLogModel;

class Laporan extends BaseController
{
    public function index()
    {
        $kasSaldoModel   = new KasSaldoModel();
        $kasMasukModel   = new KasMasukModel();
        $kasKeluarModel  = new KasKeluarModel();
        $pengajuanModel  = new PengajuanModel();
        $userModel       = new UserModel();
        $activityModel   = new ActivityLogModel();

        $data = [
            'title'             => 'Laporan Kas',
            'saldo'             => $kasSaldoModel->first(),
            'total_masuk'       => $kasMasukModel->selectSum('nominal', 'total')->first(),
            'total_keluar'      => $kasKeluarModel->selectSum('nominal', 'total')->first(),
            'total_pengajuan'   => $pengajuanModel->countAll(),
            'total_user'        => $userModel->countAllResults(),
            'pengajuan_pending' => $pengajuanModel->where('status', 'pending')->countAllResults(),
            'pengajuan_ditolak' => $pengajuanModel->where('status', 'ditolak')->countAllResults(),
            'activities'        => $activityModel->getAllActivities(20),
        ];

        return view('admin/laporan/index', $data);
    }
}
