<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $pengajuanModel;
    protected $userModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
        $this->userModel = new UserModel();
        helper(['format']); // Load helper format
    }

    public function index()
    {
        $session = session();
        $userId = $session->get('id');

        // Data statistik dasar
        $data = [
            'total_pengajuan' => $this->pengajuanModel->where('user_id', $userId)->countAllResults(),
            'pengajuan_pending' => $this->pengajuanModel->where(['user_id' => $userId, 'status' => 'pending'])->countAllResults(),
            'pengajuan_ditolak' => $this->pengajuanModel->where(['user_id' => $userId, 'status' => 'ditolak'])->countAllResults(),
            'pengajuan_selesai' => $this->pengajuanModel->where(['user_id' => $userId, 'status' => 'selesai'])->countAllResults() // TAMBAHKAN INI
        ];

        // ⭐ 1. Data untuk Grafik Statistik
        $data['chart_data'] = $this->getChartData($userId);

        // ⭐ 2. Daftar Pengajuan Terbaru
        $data['recent_pengajuan'] = $this->getRecentPengajuan($userId);

        // ⭐ 4. Progress Pengajuan Berjalan
        $data['active_pengajuan'] = $this->getActivePengajuan($userId);

        return view('user/dashboard', $data);
    }

    /**
     * Method untuk mengambil detail pengajuan via AJAX
     */
    public function get_detail($type, $id)
    {
        // Validasi input
        if ($type !== 'pengajuan' || !is_numeric($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Parameter tidak valid'
            ]);
        }

        $session = session();
        $userId = $session->get('id');

        // Pastikan pengajuan milik user yang login
        $item = $this->pengajuanModel
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($item) {
            $data = [
                'success' => true,
                'title' => 'Pengajuan',
                'html' => $this->getPengajuanDetailHtml($item)
            ];
        } else {
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

        // Format tanggal
        $createdAt = date('d/m/Y H:i', strtotime($item['created_at']));
        $updatedAt = date('d/m/Y H:i', strtotime($item['updated_at'] ?? $item['created_at']));

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
                    <span class="detail-value">' . $createdAt . '</span>
                </div>';

        // Tambahkan tanggal update hanya jika berbeda dengan created_at
        if ($item['updated_at'] && $item['updated_at'] != $item['created_at']) {
            $html .= '
                <div class="detail-row">
                    <span class="detail-label">Tanggal Update</span>
                    <span class="detail-value">' . $updatedAt . '</span>
                </div>';
        }

        $html .= '
            </div>';

        // Tambahkan catatan hanya jika ada
        if (!empty($item['catatan'])) {
            $html .= '
            <div class="detail-section">
                <div class="detail-row">
                    <span class="detail-label">Catatan</span>
                    <span class="detail-value">' . nl2br(htmlspecialchars($item['catatan'])) . '</span>
                </div>
            </div>';
        }

        return $html;
    }

    /**
     * ⭐ 1. Data untuk Grafik Statistik
     */
    private function getChartData($userId)
    {
        $currentYear = date('Y');
        $monthlyData = [];

        // Data untuk line chart (pengajuan per bulan)
        for ($month = 1; $month <= 12; $month++) {
            $count = $this->pengajuanModel
                ->where('user_id', $userId)
                ->where('YEAR(created_at)', $currentYear)
                ->where('MONTH(created_at)', $month)
                ->countAllResults();
            $monthlyData[] = $count;
        }

        return [
            'monthly_labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'monthly_data' => $monthlyData,
            'status_data' => [
                $this->pengajuanModel->where(['user_id' => $userId, 'status' => 'pending'])->countAllResults(),
                $this->pengajuanModel->where(['user_id' => $userId, 'status' => 'ditolak'])->countAllResults(),
                $this->pengajuanModel->where(['user_id' => $userId, 'status' => 'selesai'])->countAllResults() // TAMBAHKAN INI
            ]
        ];
    }

    /**
     * ⭐ 2. Daftar Pengajuan Terbaru
     */
    private function getRecentPengajuan($userId)
    {
        $pengajuan = $this->pengajuanModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $formatted = [];
        foreach ($pengajuan as $p) {
            $formatted[] = [
                'id' => $p['id'],
                'judul' => $p['keterangan'] ?: 'Pengajuan Kas',
                'tanggal' => format_tanggal($p['created_at'], 'd/m/Y'),
                'status' => $p['status'],
                'badge_class' => 'bg-' . get_status_badge($p['status']),
                'jumlah' => format_rupiah($p['nominal'])
            ];
        }

        return $formatted;
    }

    /**
     * ⭐ 4. Progress Pengajuan Berjalan
     */
    private function getActivePengajuan($userId)
    {
        $active = $this->pengajuanModel
            ->where('user_id', $userId)
            ->whereIn('status', ['pending', 'diproses'])
            ->orderBy('created_at', 'DESC')
            ->limit(2)
            ->findAll();

        $formatted = [];
        foreach ($active as $p) {
            $formatted[] = [
                'id' => $p['id'],
                'judul' => $p['keterangan'] ?: 'Pengajuan Kas',
                'tanggal' => format_tanggal($p['created_at'], 'd/m/Y'),
                'progress' => $this->calculateProgress($p['status']),
                'stages' => $this->getProgressStages($p['status'])
            ];
        }

        return $formatted;
    }

    private function calculateProgress($status)
    {
        $progressMap = [
            'pending' => 25,
            'diproses' => 50,
            'ditolak' => 100,
            'selesai' => 100
        ];

        return $progressMap[$status] ?? 0;
    }

    private function getProgressStages($currentStatus)
    {
        $stages = [
            ['name' => 'Pengajuan', 'completed' => true, 'active' => false],
            ['name' => 'Verifikasi', 'completed' => false, 'active' => false],
            ['name' => 'Review', 'completed' => false, 'active' => false],
            ['name' => 'Selesai', 'completed' => false, 'active' => false]
        ];

        switch ($currentStatus) {
            case 'pending':
                $stages[1]['active'] = true;
                break;
            case 'diproses':
                $stages[1]['completed'] = true;
                $stages[2]['active'] = true;
                break;
            case 'ditolak':
            case 'selesai':
                $stages[1]['completed'] = true;
                $stages[2]['completed'] = true;
                $stages[3]['completed'] = true;
                $stages[3]['active'] = true;
                break;
        }

        return $stages;
    }
}