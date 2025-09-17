<?php
namespace App\Models;

use CodeIgniter\Model;

class RealisasiPengajuanModel extends Model
{
    protected $table = 'realisasi_pengajuan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pengajuan_id', 'kas_keluar_id', 'metode_pembayaran', 'status_realisasi', 'tanggal_realisasi'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function realisasikanPengajuan($pengajuanId, $kasKeluarId, $metode)
    {
        $data = [
            'pengajuan_id' => $pengajuanId,
            'kas_keluar_id' => $kasKeluarId,
            'metode_pembayaran' => $metode,
            'status_realisasi' => 'selesai',
            'tanggal_realisasi' => date('Y-m-d H:i:s')
        ];
        return $this->insert($data);
    }
}