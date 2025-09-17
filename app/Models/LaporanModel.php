<?php
namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getKasSummary($start_date = null, $end_date = null)
    {
        $builderMasuk = $this->db->table('kas_masuk')
            ->select("DATE(created_at) as bulan, SUM(nominal) as total")
            ->groupBy("DATE(created_at)")
            ->orderBy("bulan", 'ASC');

        $builderKeluar = $this->db->table('kas_keluar')
            ->select("DATE(created_at) as bulan, SUM(nominal) as total")
            ->groupBy("DATE(created_at)")
            ->orderBy("bulan", 'ASC');

        // Filter tanggal jika ada
        if ($start_date && $end_date) {
            $builderMasuk->where("DATE(created_at) >=", $start_date)
                         ->where("DATE(created_at) <=", $end_date);
            $builderKeluar->where("DATE(created_at) >=", $start_date)
                          ->where("DATE(created_at) <=", $end_date);
        }

        $kasMasuk = $builderMasuk->get()->getResultArray();
        $kasKeluar = $builderKeluar->get()->getResultArray();

        return [
            'masuk' => $kasMasuk,
            'keluar' => $kasKeluar
        ];
    }
}
