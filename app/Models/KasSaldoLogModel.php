<?php
namespace App\Models;

use CodeIgniter\Model;

class KasSaldoLogModel extends Model
{
    protected $table = 'kas_saldo_log';
    protected $primaryKey = 'id';
    protected $allowedFields = ['kas_masuk_id', 'kas_keluar_id', 'nominal', 'tipe', 'saldo_sebelum', 'saldo_sesudah', 'keterangan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function logKasMasuk($kasMasukId, $nominal, $saldoSebelum, $saldoSesudah, $keterangan = '')
    {
        $data = [
            'kas_masuk_id' => $kasMasukId,
            'nominal' => $nominal,
            'tipe' => 'masuk',
            'saldo_sebelum' => $saldoSebelum,
            'saldo_sesudah' => $saldoSesudah,
            'keterangan' => $keterangan
        ];
        return $this->insert($data);
    }

    public function logKasKeluar($kasKeluarId, $nominal, $saldoSebelum, $saldoSesudah, $keterangan = '')
    {
        $data = [
            'kas_keluar_id' => $kasKeluarId,
            'nominal' => $nominal,
            'tipe' => 'keluar',
            'saldo_sebelum' => $saldoSebelum,
            'saldo_sesudah' => $saldoSesudah,
            'keterangan' => $keterangan
        ];
        return $this->insert($data);
    }
}