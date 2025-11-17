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
    <div class="row">
        <div class="col-12">
            <div class="quick-actions-grid">
                <div class="row g-3">
                    <!-- Baris Pertama - 2 Kartu dengan lebar sama -->
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

                    <!-- Baris Kedua - Kartu Profil Saya yang memanjang -->
                    <div class="col-12">
                        <a href="<?= site_url('user/profile') ?>" class="quick-action-card profile">
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

    /* AKSI CEPAT - TANPA BACKGROUND */
    .quick-actions-grid {
        width: 100%;
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

    /* PERBAIKAN RESPONSIVE */
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
    }

    /* Pastikan row dan col tidak memiliki padding/margin berlebihan */
    .row.g-3 {
        margin-left: -6px;
        margin-right: -6px;
    }

    .row.g-3>[class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }
</style>

<?= $this->endSection() ?>