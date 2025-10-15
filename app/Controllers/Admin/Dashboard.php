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
    protected $kasSaldoModel;
    protected $kasMasukModel;
    protected $kasKeluarModel;
    protected $pengajuanModel;
    protected $userModel;

    public function __construct()
    {
        $this->kasSaldoModel = new KasSaldoModel();
        $this->kasMasukModel = new KasMasukModel();
        $this->kasKeluarModel = new KasKeluarModel();
        $this->pengajuanModel = new PengajuanModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Ambil filter bulan (jika ada)
        $bulan = $this->request->getGet('bulan');

        // Ringkasan Kas & Pengguna
        $saldo = $this->kasSaldoModel->first();

        // Total Masuk
        $kasMasukQuery = $this->kasMasukModel->selectSum('nominal', 'total');
        if ($bulan) {
            $kasMasukQuery->where('MONTH(created_at)', $bulan);
        }
        $total_masuk = $kasMasukQuery->first();

        // Total Keluar
        $kasKeluarQuery = $this->kasKeluarModel->selectSum('nominal', 'total');
        if ($bulan) {
            $kasKeluarQuery->where('MONTH(created_at)', $bulan);
        }
        $total_keluar = $kasKeluarQuery->first();

        // Pengajuan Terbaru (5 data saja)
        $pengajuan_terbaru = $this->pengajuanModel
            ->select('pengajuan.*, users.username')
            ->join('users', 'users.id = pengajuan.user_id')
            ->when($bulan, fn($q) => $q->where('MONTH(pengajuan.created_at)', $bulan))
            ->orderBy('pengajuan.created_at', 'DESC')
            ->findAll(5);

        // Kas Masuk Terbaru (5 data)
        $kas_masuk_terbaru = $this->kasMasukModel
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Kas Keluar Terbaru (5 data)
        $kas_keluar_terbaru = $this->kasKeluarModel
            ->select('kas_keluar.*, pengajuan.user_id, users.username, pengajuan.keterangan as pengajuan_keterangan')
            ->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left')
            ->join('users', 'users.id = pengajuan.user_id', 'left')
            ->when($bulan, fn($q) => $q->where('MONTH(kas_keluar.created_at)', $bulan))
            ->orderBy('kas_keluar.created_at', 'DESC')
            ->findAll(5);

        // Hitung jumlah untuk ringkasan
        $kas_masuk_count = $this->kasMasukModel
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->countAllResults();

        $kas_keluar_count = $this->kasKeluarModel
            ->when($bulan, fn($q) => $q->where('MONTH(created_at)', $bulan))
            ->countAllResults();

        // Statistik Pengajuan
        if ($bulan) {
            $total_pengajuan = $this->pengajuanModel
                ->where('MONTH(created_at)', $bulan)
                ->countAllResults();

            $pengajuan_pending = $this->pengajuanModel
                ->where('MONTH(created_at)', $bulan)
                ->where('status', 'pending')
                ->countAllResults();

            $pengajuan_ditolak = $this->pengajuanModel
                ->where('MONTH(created_at)', $bulan)
                ->where('status', 'ditolak')
                ->countAllResults();
        } else {
            $total_pengajuan = $this->pengajuanModel->countAll();
            $pengajuan_pending = $this->pengajuanModel->where('status', 'pending')->countAllResults();
            $pengajuan_ditolak = $this->pengajuanModel->where('status', 'ditolak')->countAllResults();
        }

        // User tetap total semua
        $total_users = $this->userModel->where('role !=', 'admin')->countAllResults();

        // Rekap Bulanan untuk Grafik
        $monthlyMasuk = $this->kasMasukModel
            ->select("MONTH(created_at) as bulan, SUM(nominal) as total")
            ->groupBy("MONTH(created_at)")
            ->findAll();

        $monthlyKeluar = $this->kasKeluarModel
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

        $masukDataFinal = [];
        $keluarDataFinal = [];
        for ($i = 1; $i <= 12; $i++) {
            $masukDataFinal[] = $masukData[$i];
            $keluarDataFinal[] = $keluarData[$i];
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
            'masukData' => $masukDataFinal,
            'keluarData' => $keluarDataFinal,
            'bulanDipilih' => $bulan,
            'pengajuan_terbaru' => $pengajuan_terbaru,
            'kas_masuk_terbaru' => $kas_masuk_terbaru,
            'kas_keluar_terbaru' => $kas_keluar_terbaru,
            'kas_masuk_count' => $kas_masuk_count,
            'kas_keluar_count' => $kas_keluar_count
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Method untuk mengambil detail transaksi via AJAX
     */
    public function get_detail($type, $id)
    {
        // Validasi input
        if (!in_array($type, ['pengajuan', 'kas_masuk', 'kas_keluar']) || !is_numeric($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter tidak valid'
            ]);
        }

        $data = [];

        switch ($type) {
            case 'pengajuan':
                $item = $this->pengajuanModel
                    ->select('pengajuan.*, users.username')
                    ->join('users', 'users.id = pengajuan.user_id')
                    ->find($id);
                if ($item) {
                    $data = [
                        'success' => true,
                        'title' => 'Pengajuan',
                        'html' => $this->getPengajuanDetailHtml($item)
                    ];
                }
                break;

            case 'kas_masuk':
                $item = $this->kasMasukModel->find($id);
                if ($item) {
                    $data = [
                        'success' => true,
                        'title' => 'Kas Masuk',
                        'html' => $this->getKasMasukDetailHtml($item)
                    ];
                }
                break;

            case 'kas_keluar':
                // PERBAIKAN: Hapus pengajuan.catatan dari query karena kolom tidak ada
                $item = $this->kasKeluarModel
                    ->select('kas_keluar.*, pengajuan.user_id, users.username, pengajuan.keterangan as pengajuan_keterangan')
                    ->join('pengajuan', 'pengajuan.id = kas_keluar.pengajuan_id', 'left')
                    ->join('users', 'users.id = pengajuan.user_id', 'left')
                    ->find($id);
                if ($item) {
                    $data = [
                        'success' => true,
                        'title' => 'Kas Keluar',
                        'html' => $this->getKasKeluarDetailHtml($item)
                    ];
                }
                break;
        }

        if (empty($data)) {
            $data = [
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ];
        }

        return $this->response->setJSON($data);
    }

    /**
     * Generate HTML untuk detail Pengajuan
     */
    private function getPengajuanDetailHtml($item)
    {
        $statusClass = 'status-' . $item['status'];
        $tipeClass = $item['tipe'] === 'uang_sendiri' ? 'amount-negative' : 'amount-positive';
        $tipeLabel = $item['tipe'] === 'uang_sendiri' ? 'Uang Sendiri' : 'Uang Kas';

        // Gunakan null coalescing operator untuk menghindari error undefined key
        $catatan = $item['catatan'] ?? '';
        $updatedAt = $item['updated_at'] ?? $item['created_at'];

        $html = '
            <div class="detail-section">
                <div class="amount-large ' . $tipeClass . '">
                    Rp ' . number_format($item['nominal'], 0, ',', '.') . '
                </div>
            </div>
            
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label">ID Pengajuan</span>
                    <span class="detail-value">#' . $item['id'] . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pengaju</span>
                    <span class="detail-value">' . ($item['username'] ?? 'System') . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value">' . ($item['keterangan'] ?? '-') . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tipe</span>
                    <span class="detail-value">' . $tipeLabel . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value transaction-status ' . $statusClass . '">' . ucfirst($item['status']) . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Pengajuan</span>
                    <span class="detail-value">' . date('d/m/Y H:i', strtotime($item['created_at'])) . '</span>
                </div>';

        // Tambahkan tanggal update hanya jika berbeda dengan created_at
        if ($updatedAt != $item['created_at']) {
            $html .= '
                <div class="detail-row">
                    <span class="detail-label">Tanggal Update</span>
                    <span class="detail-value">' . date('d/m/Y H:i', strtotime($updatedAt)) . '</span>
                </div>';
        }

        $html .= '
            </div>';

        // Tambahkan catatan hanya jika ada
        if (!empty($catatan)) {
            $html .= '
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label">Catatan</span>
                    <span class="detail-value">' . $catatan . '</span>
                </div>
            </div>';
        }

        return $html;
    }

    /**
     * Generate HTML untuk detail Kas Masuk
     */
    private function getKasMasukDetailHtml($item)
    {
        // Gunakan null coalescing operator untuk menghindari error undefined key
        $updatedAt = $item['updated_at'] ?? $item['created_at'];

        $html = '
            <div class="detail-section">
                <div class="amount-large amount-positive">
                    Rp ' . number_format($item['nominal'], 0, ',', '.') . '
                </div>
            </div>
            
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label">ID Transaksi</span>
                    <span class="detail-value">#' . $item['id'] . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value">' . ($item['keterangan'] ?? '-') . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Transaksi</span>
                    <span class="detail-value">' . date('d/m/Y H:i', strtotime($item['created_at'])) . '</span>
                </div>';

        // Tambahkan tanggal update hanya jika berbeda dengan created_at
        if ($updatedAt != $item['created_at']) {
            $html .= '
                <div class="detail-row">
                    <span class="detail-label">Tanggal Update</span>
                    <span class="detail-value">' . date('d/m/Y H:i', strtotime($updatedAt)) . '</span>
                </div>';
        }

        $html .= '
            </div>';

        return $html;
    }

    /**
     * Generate HTML untuk detail Kas Keluar
     */
    private function getKasKeluarDetailHtml($item)
    {
        // PERBAIKAN: Hapus referensi ke pengajuan_catatan karena kolom tidak ada
        $catatan = $item['catatan'] ?? '';
        $updatedAt = $item['updated_at'] ?? $item['created_at'];
        $keterangan = $item['pengajuan_keterangan'] ?? $item['keterangan'] ?? '-';

        $html = '
            <div class="detail-section">
                <div class="amount-large amount-negative">
                    Rp ' . number_format($item['nominal'], 0, ',', '.') . '
                </div>
            </div>
            
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label">ID Transaksi</span>
                    <span class="detail-value">#' . $item['id'] . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Penerima</span>
                    <span class="detail-value">' . ($item['username'] ?? 'System') . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value">' . $keterangan . '</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tanggal Transaksi</span>
                    <span class="detail-value">' . date('d/m/Y H:i', strtotime($item['created_at'])) . '</span>
                </div>';

        // Tambahkan tanggal update hanya jika berbeda dengan created_at
        if ($updatedAt != $item['created_at']) {
            $html .= '
                <div class="detail-row">
                    <span class="detail-label">Tanggal Update</span>
                    <span class="detail-value">' . date('d/m/Y H:i', strtotime($updatedAt)) . '</span>
                </div>';
        }

        $html .= '
            </div>';

        // Tambahkan catatan hanya jika ada (dari kas_keluar.catatan)
        if (!empty($catatan)) {
            $html .= '
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label">Catatan</span>
                    <span class="detail-value">' . $catatan . '</span>
                </div>
            </div>';
        }

        return $html;
    }
}