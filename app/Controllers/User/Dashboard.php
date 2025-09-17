<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();
        $session = session();
        
        $data = [
            'total_pengajuan' => $model->where('user_id', $session->get('id'))->countAllResults(),
            'pengajuan_diterima' => $model->where(['user_id' => $session->get('id'), 'status' => 'diterima'])->countAllResults(),
            'pengajuan_pending' => $model->where(['user_id' => $session->get('id'), 'status' => 'pending'])->countAllResults(),
            'pengajuan_ditolak' => $model->where(['user_id' => $session->get('id'), 'status' => 'ditolak'])->countAllResults()
        ];
        
        return view('user/dashboard', $data);
    }
}