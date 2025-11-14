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
                            <h6 class="text-muted mb-1">Total Pengajuan</h6>
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
                            <h6 class="text-muted mb-1">Diterima</h6>
                            <h3 class="text-white mb-0"><?= $pengajuan_diterima ?></h3>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-success bg-opacity-25 text-success">
                            <i class="bi bi-check-lg me-1"></i> Pengajuan disetujui
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
                            <h6 class="text-muted mb-1">Pending</h6>
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
                            <h6 class="text-muted mb-1">Ditolak</h6>
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

   

        <!-- Aksi Cepat -->
        <div class="col-lg-8 mb-4">
            <div class="card-body d-flex flex-column bg-transparent p-0">
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
                                        <div class="action-desc">Kelola semua pengajuan Anda</div>
                                    </div>
                                </div>
                                <div class="action-indicator">
                                    <span class="action-badge"><?= $total_pengajuan ?> Total</span>
                                    <i class="bi bi-arrow-right action-arrow"></i>
                                </div>
                            </a>
                        </div>

                        <!-- Baris Kedua - Kartu Profil Saya yang Panjang -->
                        <div class="col-12">
                            <a href="<?= site_url('user/profile') ?>" class="quick-action-card profile full-width">
                                <div class="action-content-wrapper">
                                    <div class="action-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="action-content">
                                        <div class="action-title">Profil Saya</div>
                                        <div class="action-desc">Kelola informasi akun dan preferensi Anda</div>
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
        </div>
    </div>

    
</div>



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

    /* Dashboard Card untuk Diagram Donat */
    .dashboard-card {
        background: linear-gradient(145deg, rgba(33, 33, 33, 0.9), rgba(26, 26, 26, 0.9));
        border-radius: 16px;
        box-shadow:
            0 4px 20px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .text-steam-blue {
        color: #66c0f4 !important;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        background-color: rgba(102, 192, 244, 0.15);
        color: #66c0f4;
    }

    /* Modern Donut Container - Diperbesar */
    .modern-donut-container {
        background: linear-gradient(145deg, rgba(26, 26, 26, 0.7), rgba(40, 40, 40, 0.7));
        border-radius: 12px;
        padding: 2rem;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.05),
            0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.08);
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .percentage-display {
        background: rgba(26, 26, 26, 0.8);
        border-radius: 50%;
        width: 120px;
        height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .percentage-display h2 {
        font-size: 2rem;
        font-weight: 700;
    }

    .percentage-display small {
        font-size: 0.8rem;
    }

    /* AKSI CEPAT */
    .quick-actions-grid {
        flex: 1;
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
        border: 1px solid transparent;
        height: 100%;
        min-height: 100px;
    }

    /* Kartu Profil Saya yang Panjang */
    .quick-action-card.full-width {
        min-height: 100px;
        width: 100%;
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
    }

    .action-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 4px;
        color: var(--text);
    }

    .action-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .action-indicator {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .action-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-muted);
    }

    .action-arrow {
        color: var(--text-muted);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .quick-action-card:hover .action-arrow {
        transform: translateX(4px);
        color: var(--text);
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

    .transaction-icon.pending {
        background: rgba(255, 152, 0, 0.15);
        color: var(--warning);
        border: 1px solid rgba(255, 152, 0, 0.3);
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

    .amount.warning {
        color: var(--warning);
    }

    .transaction-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        margin-top: 4px;
        display: inline-block;
    }

    .status-diterima {
        background: rgba(76, 175, 80, 0.2);
        color: var(--success);
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

    /* Responsive */
    @media (max-width: 768px) {
        .quick-action-card {
            min-height: 90px;
            padding: 16px;
        }

        .quick-action-card.full-width {
            min-height: 90px;
        }

        .quick-action-card .action-icon {
            width: 44px;
            height: 44px;
            font-size: 1.3rem;
            margin-right: 12px;
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

        .percentage-display {
            width: 100px;
            height: 100px;
        }

        .percentage-display h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .quick-action-card {
            flex-direction: column;
            text-align: center;
            padding: 20px 16px;
        }

        .quick-action-card.full-width {
            flex-direction: row;
            text-align: left;
        }

        .action-content-wrapper {
            flex-direction: column;
            text-align: center;
            margin-bottom: 12px;
        }

        .quick-action-card.full-width .action-content-wrapper {
            flex-direction: row;
            text-align: left;
            margin-bottom: 0;
        }

        .quick-action-card .action-icon {
            margin-right: 0;
            margin-bottom: 8px;
        }

        .quick-action-card.full-width .action-icon {
            margin-right: 16px;
            margin-bottom: 0;
        }

        .action-indicator {
            flex-direction: row;
            justify-content: center;
            width: 100%;
        }

        .quick-action-card.full-width .action-indicator {
            width: auto;
        }

        .modern-donut-container {
            padding: 1rem;
        }

        .percentage-display {
            width: 80px;
            height: 80px;
        }

        .percentage-display h2 {
            font-size: 1.25rem;
        }
    }

    .btn-outline-light {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }
</style>

<?= $this->endSection() ?>