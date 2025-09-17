<?php
namespace App\Services;

use App\Models\KasSaldoModel;
use App\Models\KasSaldoLogModel;
use App\Models\ActivityLogModel;

class KasService
{
    protected $kasSaldoModel;
    protected $kasSaldoLogModel;
    protected $activityLogModel;

    public function __construct()
    {
        $this->kasSaldoModel = new KasSaldoModel();
        $this->kasSaldoLogModel = new KasSaldoLogModel();
        $this->activityLogModel = new ActivityLogModel();
    }

    public function tambahKasMasuk($nominal, $keterangan, $userId)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Dapatkan saldo saat ini
            $saldo = $this->kasSaldoModel->first();
            $saldoSebelum = $saldo ? $saldo['saldo_akhir'] : 0;
            $saldoSesudah = $saldoSebelum + $nominal;

            // Simpan kas masuk
            $kasMasukData = [
                'nominal' => $nominal,
                'keterangan' => $keterangan
            ];
            $kasMasukId = $this->kasSaldoModel->insert($kasMasukData);

            // Update saldo
            if ($saldo) {
                $this->kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $saldoSesudah]);
            } else {
                $this->kasSaldoModel->insert(['saldo_akhir' => $saldoSesudah]);
            }

            // Log perubahan saldo
            $this->kasSaldoLogModel->logKasMasuk($kasMasukId, $nominal, $saldoSebelum, $saldoSesudah, $keterangan);

            // Log activity
            $this->activityLogModel->logActivity($userId, 'kas_masuk', 'Menambah kas masuk: Rp ' . number_format($nominal, 0, ',', '.'));

            $db->transComplete();
            return $kasMasukId;

        } catch (\Exception $e) {
            $db->transRollback();
            throw new \Exception('Gagal menambah kas masuk: ' . $e->getMessage());
        }
    }

    public function prosesKasKeluar($pengajuanId, $nominal, $keterangan, $metode, $userId, $fileNota = null)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $saldo = $this->kasSaldoModel->first();
            $saldoSebelum = $saldo ? $saldo['saldo_akhir'] : 0;

            if ($metode == 'minta_uang' && $saldoSebelum < $nominal) {
                throw new \Exception('Saldo tidak mencukupi');
            }

            $saldoSesudah = $metode == 'minta_uang' ? $saldoSebelum - $nominal : $saldoSebelum;

            // Simpan kas keluar
            $kasKeluarData = [
                'pengajuan_id' => $pengajuanId,
                'nominal' => $nominal,
                'keterangan' => $keterangan,
                'file_nota' => $fileNota
            ];
            $kasKeluarId = $this->kasSaldoModel->insert($kasKeluarData);

            // Update saldo jika metode minta uang
            if ($metode == 'minta_uang' && $saldo) {
                $this->kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $saldoSesudah]);
            }

            // Log perubahan saldo
            $this->kasSaldoLogModel->logKasKeluar($kasKeluarId, $nominal, $saldoSebelum, $saldoSesudah, $keterangan);

            // Log activity
            $this->activityLogModel->logActivity($userId, 'kas_keluar', 'Memproses kas keluar: Rp ' . number_format($nominal, 0, ',', '.'));

            $db->transComplete();
            return $kasKeluarId;

        } catch (\Exception $e) {
            $db->transRollback();
            throw new \Exception('Gagal memproses kas keluar: ' . $e->getMessage());
        }
    }

    public function getSaldo()
    {
        $saldo = $this->kasSaldoModel->first();
        return $saldo ? $saldo['saldo_akhir'] : 0;
    }

    public function getRiwayatSaldo($limit = 50)
    {
        return $this->kasSaldoLogModel->orderBy('created_at', 'DESC')->findAll($limit);
    }
}