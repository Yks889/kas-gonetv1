<?php
namespace App\Services;

use App\Models\PengajuanModel;
use App\Models\RealisasiPengajuanModel;
use App\Models\NotificationModel;
use App\Models\ActivityLogModel;

class PengajuanService
{
    protected $pengajuanModel;
    protected $realisasiModel;
    protected $notificationModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
        $this->realisasiModel = new RealisasiPengajuanModel();
        $this->notificationModel = new NotificationModel();
        $this->activityLogModel = new ActivityLogModel();
    }

    public function buatPengajuan($userId, $nominal, $keterangan, $deadline = null)
    {
        $data = [
            'user_id' => $userId,
            'nominal' => $nominal,
            'keterangan' => $keterangan,
            'deadline' => $deadline,
            'status' => 'pending'
        ];

        $pengajuanId = $this->pengajuanModel->insert($data);

        // Notifikasi ke admin
        $this->notificationModel->insert([
            'user_id' => 1, // Admin user ID
            'message' => 'Pengajuan kas baru menunggu persetujuan'
        ]);

        $this->activityLogModel->logActivity($userId, 'pengajuan_baru', 'Membuat pengajuan kas: Rp ' . number_format($nominal, 0, ',', '.'));

        return $pengajuanId;
    }

    public function setujuiPengajuan($pengajuanId, $adminId)
    {
        $this->pengajuanModel->update($pengajuanId, ['status' => 'diterima']);

        $pengajuan = $this->pengajuanModel->find($pengajuanId);
        
        // Notifikasi ke user
        $this->notificationModel->insert([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda disetujui'
        ]);

        $this->activityLogModel->logActivity($adminId, 'pengajuan_disetujui', 'Menyetujui pengajuan ID: ' . $pengajuanId);
    }

    public function tolakPengajuan($pengajuanId, $adminId, $alasan = '')
    {
        $this->pengajuanModel->update($pengajuanId, ['status' => 'ditolak']);

        $pengajuan = $this->pengajuanModel->find($pengajuanId);
        
        // Notifikasi ke user
        $this->notificationModel->insert([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda ditolak' . ($alasan ? ': ' . $alasan : '')
        ]);

        $this->activityLogModel->logActivity($adminId, 'pengajuan_ditolak', 'Menolak pengajuan ID: ' . $pengajuanId);
    }

    public function realisasikanPengajuan($pengajuanId, $kasKeluarId, $metode, $adminId)
    {
        $this->realisasiModel->realisasikanPengajuan($pengajuanId, $kasKeluarId, $metode);
        $this->pengajuanModel->update($pengajuanId, ['status' => 'diproses']);

        $pengajuan = $this->pengajuanModel->find($pengajuanId);
        
        // Notifikasi ke user
        $this->notificationModel->insert([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda sedang diproses'
        ]);

        $this->activityLogModel->logActivity($adminId, 'pengajuan_direalisasikan', 'Merealisasikan pengajuan ID: ' . $pengajuanId);
    }

    public function getPengajuanByUser($userId)
    {
        return $this->pengajuanModel->where('user_id', $userId)
                                  ->orderBy('created_at', 'DESC')
                                  ->findAll();
    }

    public function getPengajuanPending()
    {
        return $this->pengajuanModel->where('status', 'pending')
                                  ->orderBy('created_at', 'DESC')
                                  ->findAll();
    }

    public function cekDeadlinePengajuan()
    {
        $today = date('Y-m-d');
        $pengajuan = $this->pengajuanModel->where('deadline <=', $today)
                                        ->where('status', 'pending')
                                        ->findAll();

        foreach ($pengajuan as $p) {
            $this->notificationModel->insert([
                'user_id' => 1, // Admin
                'message' => 'Pengajuan ID ' . $p['id'] . ' sudah melewati deadline'
            ]);
        }

        return count($pengajuan);
    }
}