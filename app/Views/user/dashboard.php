<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-white">
                <i class="bi bi-person me-2"></i>Dashboard User GoNet
            </h1>
            <p class="mb-0 text-light">Ringkasan pengajuan dan statistik akun Anda</p>
        </div>
    </div>

    <!-- Ringkasan Pengajuan -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="bank-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon"><i class="bi bi-list-check"></i></div>
                        <div class="ms-3">
                            <h6 class="text-white mb-1">Total Pengajuan</h6>
                            <h3 class="text-white mb-0"><?= $total_pengajuan ?></h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-primary bg-opacity-25 text-primary">
                            <i class="bi bi-file-earmark-text me-1"></i> Semua pengajuan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bank-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon"><i class="bi bi-check-circle"></i></div>
                        <div class="ms-3">
                            <h6 class="text-white mb-1">Selesai</h6>
                            <h3 class="text-white mb-0"><?= $pengajuan_selesai ?></h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-25 text-success">
                            <i class="bi bi-check-lg me-1"></i> Pengajuan selesai
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bank-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon"><i class="bi bi-clock-history"></i></div>
                        <div class="ms-3">
                            <h6 class="text-white mb-1">Pending</h6>
                            <h3 class="text-white mb-0"><?= $pengajuan_pending ?></h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-warning bg-opacity-25 text-warning">
                            <i class="bi bi-hourglass-split me-1"></i> Menunggu persetujuan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bank-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon"><i class="bi bi-x-circle"></i></div>
                        <div class="ms-3">
                            <h6 class="text-white mb-1">Ditolak</h6>
                            <h3 class="text-white mb-0"><?= $pengajuan_ditolak ?></h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-danger bg-opacity-25 text-danger">
                            <i class="bi bi-exclamation-triangle me-1"></i> Pengajuan ditolak
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- AKSI CEPAT -->
        <div class="col-md-8">
            <div class="quick-actions-grid">
                <div class="row g-3">
                    <!-- Baris Pertama - 2 Kartu -->
                    <div class="col-md-6">
                        <a href="<?= site_url('user/pengajuan/create') ?>" class="quick-action-card create">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-plus-circle"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Ajukan Kas Baru</div>
                                    <div class="action-desc">Buat pengajuan dana baru</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge">Baru</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6">
                        <a href="<?= site_url('user/pengajuan') ?>" class="quick-action-card pengajuan">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-list-ul"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Lihat Pengajuan</div>
                                    <div class="action-desc">Kelola semua pengajuan</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge"><?= $total_pengajuan ?> Total</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>

                    <!-- Baris Kedua - Kartu Profil -->
                    <div class="col-12">
                        <a href="<?= site_url('user/profile') ?>" class="quick-action-card profile">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Profil Saya</div>
                                    <div class="action-desc">Kelola informasi akun</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge">Update</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Informasi Perusahaan -->
            <div class="bank-card">
                <div class="card-header">
                    <h5 class="text-white mb-0"><i class="bi bi-building me-2"></i>Informasi Gonet</h5>
                </div>
                <div class="card-body">
                    <div class="company-info">
                        <div class="info-item mb-2 d-flex align-items-center">
                            <i class="bi bi-headset me-2 text-primary"></i>
                            <span class="text-white">Support: (021) 1234-5678</span>
                        </div>
                        <div class="info-item mb-2 d-flex align-items-center">
                            <i class="bi bi-whatsapp me-2 text-success"></i>
                            <span class="text-white">WhatsApp: 0812-3456-7890</span>
                        </div>
                        <div class="info-item mb-2 d-flex align-items-center">
                            <i class="bi bi-clock me-2 text-warning"></i>
                            <span class="text-white">Jam: 09.00 - 17.00</span>
                        </div>
                        <div class="info-item d-flex align-items-center">
                            <i class="bi bi-envelope me-2 text-info"></i>
                            <span class="text-white">Email: support@gonet.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PENGATURAN TERBARU - DIUBAH MENJADI TAMPILAN SEPERTI ADMIN -->
    <div class="row">
        <div class="col-12">
            <div class="bank-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Pengajuan Terbaru</h5>
                        <a href="<?= site_url('user/pengajuan') ?>" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-list-ul me-1"></i>Lihat Semua
                        </a>
                    </div>

                    <div class="transaction-list">
                        <?php if (empty($recent_pengajuan)): ?>
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada pengajuan</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_pengajuan as $item): ?>
                                <div class="transaction-item clickable" data-type="pengajuan" data-id="<?= $item['id'] ?>"
                                    onclick="showDetailPopup(this)">
                                    <div class="transaction-details">
                                        <div
                                            class="transaction-icon <?= $item['status'] === 'ditolak' ? 'expense' : 'income' ?>">
                                            <i
                                                class="bi <?= $item['status'] === 'ditolak' ? 'bi-x-circle' : ($item['status'] === 'selesai' ? 'bi-check-circle' : 'bi-clock') ?>"></i>
                                        </div>
                                        <div class="transaction-info">
                                            <div class="transaction-description"><?= $item['judul'] ?></div>
                                            <div class="transaction-date"><?= $item['tanggal'] ?></div>
                                        </div>
                                    </div>
                                    <div class="transaction-amount">
                                        <div class="amount <?= $item['status'] === 'ditolak' ? 'negative' : 'positive' ?>">
                                            <?= $item['jumlah'] ?>
                                        </div>
                                        <div class="transaction-status status-<?= $item['status'] ?>">
                                            <?= ucfirst($item['status']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pengajuan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Konten detail akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Grafik Statistik
    document.addEventListener('DOMContentLoaded', function () {
        // Line Chart - Statistik Bulanan
        const lineCtx = document.getElementById('lineChart');
        if (lineCtx) {
            const lineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($chart_data['monthly_labels'] ?? []) ?>,
                    datasets: [{
                        label: 'Jumlah Pengajuan',
                        data: <?= json_encode($chart_data['monthly_data'] ?? []) ?>,
                        borderColor: '#66c0f4',
                        backgroundColor: 'rgba(102, 192, 244, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#b0b0b0'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#b0b0b0'
                            }
                        }
                    }
                }
            });
        }

        // Doughnut Chart - Status Pengajuan
        const doughnutCtx = document.getElementById('doughnutChart');
        if (doughnutCtx) {
            const doughnutChart = new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Pending', 'Ditolak'],
                    datasets: [{
                        data: <?= json_encode($chart_data['status_data'] ?? [0, 0, 0]) ?>,
                        backgroundColor: [
                            'rgba(76, 175, 80, 0.7)',
                            'rgba(255, 152, 0, 0.7)',
                            'rgba(244, 67, 54, 0.7)'
                        ],
                        borderColor: [
                            'rgba(76, 175, 80, 1)',
                            'rgba(255, 152, 0, 1)',
                            'rgba(244, 67, 54, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#b0b0b0',
                                padding: 20
                            }
                        }
                    }
                }
            });
        }
    });

    // Fungsi untuk menampilkan popup detail
    function showDetailPopup(element) {
        const type = element.getAttribute('data-type');
        const id = element.getAttribute('data-id');

        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
        `;

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();

        // Load data via AJAX
        fetch(`<?= site_url('user/dashboard/get_detail/') ?>${type}/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('detailContent').innerHTML = data.html;
                    document.getElementById('detailModalLabel').textContent = `Detail ${data.title}`;
                } else {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> ${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('detailContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan saat memuat data.
                    </div>
                `;
            });
    }
</script>

<!-- STYLE TAMBAHAN UNTUK TAMPILAN SEPERTI ADMIN -->
<style>
    :root {
        --primary: #1a73e8;
        --primary-dark: #0d47a1;
        --secondary: #6c757d;
        --success: #4caf50;
        --danger: #f44336;
        --warning: #ff9800;
        --info: #2196f3;
        --dark: #121212;
        --dark-light: #1e1e1e;
        --text: #fff;
        --text-muted: #b0b0b0;
        --border: rgba(255, 255, 255, 0.1);
    }

    /* Modal Styling */
    .modal-content {
        background: var(--dark-light);
        border-radius: 16px;
        border: 1px solid var(--border);
        color: var(--text);
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 20px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 15px 20px;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Transaction item clickable */
    .transaction-item.clickable {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .transaction-item.clickable:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        transform: translateX(5px);
    }

    /* Detail Content Styling */
    .detail-section {
        margin-bottom: 20px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border-left: 4px solid var(--primary);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-muted);
    }

    .detail-value {
        text-align: right;
    }

    .amount-large {
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        padding: 15px;
        border-radius: 10px;
        margin: 15px 0;
    }

    .amount-positive {
        background: rgba(76, 175, 80, 0.2);
        color: var(--success);
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .amount-negative {
        background: rgba(239, 83, 80, 0.2);
        color: var(--danger);
        border: 1px solid rgba(239, 83, 80, 0.3);
    }

    /* Kartu Bank */
    .bank-card {
        background: var(--dark-light);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border);
        padding: 24px;
        transition: .3s;
        color: var(--text);
        height: 100%;
    }

    .bank-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    /* Daftar Transaksi */
    .transaction-category {
        margin-bottom: 25px;
    }

    .category-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
    }

    .transaction-list .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s;
    }

    .transaction-list .transaction-item:hover {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .transaction-list .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-details {
        display: flex;
        align-items: center;
    }

    .transaction-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
    }

    .transaction-icon.income {
        background: rgba(76, 175, 80, 0.15);
        color: var(--success);
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .transaction-icon.expense {
        background: rgba(239, 83, 80, 0.15);
        color: var(--danger);
        border: 1px solid rgba(239, 83, 80, 0.3);
    }

    .transaction-info {
        flex: 1;
    }

    .transaction-description {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .transaction-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .amount {
        font-weight: 600;
    }

    .amount.positive {
        color: var(--success);
    }

    .amount.negative {
        color: var(--danger);
    }

    .transaction-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        margin-top: 4px;
        display: inline-block;
    }

    .status-selesai {
        background: rgba(76, 175, 80, 0.2);
        color: var(--success);
    }

    .status-diproses {
        background: rgba(33, 150, 243, 0.2);
        color: var(--info);
    }

    .status-ditolak {
        background: rgba(239, 83, 80, 0.2);
        color: var(--danger);
    }

    .status-pending {
        background: rgba(255, 152, 0, 0.2);
        color: var(--warning);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 30px;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 2rem;
        opacity: .5;
        margin-bottom: 6px;
    }

    /* AKSI CEPAT */
    .quick-actions-grid {
        width: 100%;
        height: 100%;
    }

    .quick-action-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        background: var(--dark-light);
        border-radius: 12px;
        text-decoration: none;
        color: var(--text);
        transition: all 0.3s ease;
        border: 1px solid var(--border);
        height: 100%;
        min-height: 100px;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 12px;
    }

    .quick-action-card:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
        border-color: rgba(255, 255, 255, 0.2);
        text-decoration: none;
        color: var(--text);
    }

    .action-content-wrapper {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 0;
    }

    .quick-action-card .action-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 1.5rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .quick-action-card.create .action-icon {
        background: rgba(76, 175, 80, 0.15);
        color: var(--success);
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .quick-action-card.pengajuan .action-icon {
        background: rgba(33, 150, 243, 0.15);
        color: var(--info);
        border: 1px solid rgba(33, 150, 243, 0.3);
    }

    .quick-action-card.profile .action-icon {
        background: rgba(255, 152, 0, 0.15);
        color: var(--warning);
        border: 1px solid rgba(255, 152, 0, 0.3);
    }

    .quick-action-card:hover .action-icon {
        transform: scale(1.1);
    }

    .action-content {
        flex: 1;
        min-width: 0;
    }

    .action-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 4px;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .action-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.4;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .action-indicator {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
        margin-left: 12px;
    }

    .action-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-muted);
        white-space: nowrap;
    }

    .action-arrow {
        color: var(--text-muted);
        transition: all 0.3s ease;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .quick-action-card:hover .action-arrow {
        transform: translateX(4px);
        color: var(--text);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quick-action-card {
            min-height: 90px;
            padding: 16px;
        }

        .quick-action-card .action-icon {
            width: 44px;
            height: 44px;
            font-size: 1.3rem;
            margin-right: 12px;
        }

        .action-title {
            font-size: 0.9rem;
        }

        .action-desc {
            font-size: 0.75rem;
        }

        .action-badge {
            font-size: 0.7rem;
            padding: 3px 6px;
        }

        .transaction-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .transaction-amount {
            margin-top: 8px;
            text-align: left;
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .quick-action-card {
            padding: 14px;
            min-height: 85px;
        }

        .action-content-wrapper {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .quick-action-card .action-icon {
            margin-right: 0;
            margin-bottom: 8px;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }

        .action-indicator {
            margin-left: 0;
            margin-top: 8px;
            width: 100%;
            justify-content: space-between;
        }

        .action-content {
            width: 100%;
        }

        .action-title,
        .action-desc {
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
        }

        .detail-row {
            flex-direction: column;
        }

        .detail-value {
            text-align: left;
            margin-top: 5px;
        }
    }
</style>

<?= $this->endSection() ?>