<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-cash-coin me-2"></i> Manajemen Pengajuan
        </h1>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show stylish-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show stylish-alert" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-cash-stack text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Total Nominal</h5>
                        <h3 class="card-value text-success mb-0">
                            Rp <?= isset($total_nominal) ? number_format($total_nominal, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Total seluruh nominal pengajuan
                    </small>
                </div>
            </div>
        </div>

        <!-- Pengajuan Pending -->
        <div class="col-md-3 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-clock-history text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Menunggu</h5>
                        <h3 class="card-value text-warning mb-0">
                            <?= isset($total_pending) ? number_format($total_pending, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Pengajuan menunggu persetujuan
                    </small>
                </div>
            </div>
        </div>

        <!-- Pengajuan Selesai -->
        <div class="col-md-3 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-check-circle text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Selesai</h5>
                        <h3 class="card-value text-primary mb-0">
                            <?= isset($total_selesai) ? number_format($total_selesai, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Pengajuan yang disetujui
                    </small>
                </div>
            </div>
        </div>

        <!-- Total User Mengajukan -->
        <div class="col-md-3 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-people text-white"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">User Mengajukan</h5>
                        <h3 class="card-value text-white mb-0">
                            <?= isset($total_user) ? number_format($total_user, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Jumlah user yang melakukan pengajuan
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="row mb-3 g-2">
        <!-- Rows per page -->
        <div class="col-md-3 d-flex align-items-center">
            <label class="text-white me-2">Tampilkan</label>
            <select id="rowsPerPage" class="form-select form-select-sm modern-select w-auto">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <label class="text-white ms-2">baris</label>
        </div>

        <!-- Search + Filter Toggle -->
        <div class="col-md-9 d-flex align-items-center gap-2">
            <div class="modern-search flex-grow-1 d-flex align-items-center">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm w-100"
                    placeholder="Cari berdasarkan user, keterangan, atau nominal...">
            </div>
            <button class="btn btn-outline-light stylish-filter-btn" type="button" data-bs-toggle="modal"
                data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill me-1"></i> Filter
            </button>
        </div>

        <!-- Modal Filter -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content stylish-modal">
                    <div class="modal-header stylish-modal-header">
                        <div class="d-flex align-items-center">
                            <div class="modal-icon me-3">
                                <i class="bi bi-funnel-fill"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0">Filter Pengajuan</h5>
                                <p class="modal-subtitle mb-0">Saring data berdasarkan kriteria tertentu</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body stylish-modal-body">
                        <div class="row g-3">
                            <!-- Filter Status -->
                            <div class="col-md-6">
                                <label for="filterStatus" class="form-label stylish-label">
                                    <i class="bi bi-tag me-2"></i> Status
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterStatus" class="form-select stylish-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" <?= ($current_filters['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="diterima" <?= ($current_filters['status'] ?? '') == 'diterima' ? 'selected' : '' ?>>Diterima</option>
                                        <option value="ditolak" <?= ($current_filters['status'] ?? '') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                        <option value="selesai" <?= ($current_filters['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                            </div>

                            <!-- Filter Tipe -->
                            <div class="col-md-6">
                                <label for="filterTipe" class="form-label stylish-label">
                                    <i class="bi bi-currency-exchange me-2"></i> Tipe
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterTipe" class="form-select stylish-select">
                                        <option value="">Semua Tipe</option>
                                        <option value="uang_sendiri" <?= ($current_filters['tipe'] ?? '') == 'uang_sendiri' ? 'selected' : '' ?>>Uang Sendiri</option>
                                        <option value="minta_admin" <?= ($current_filters['tipe'] ?? '') == 'minta_admin' ? 'selected' : '' ?>>Minta Admin</option>
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                            </div>

                            <!-- Filter Bulan -->
                            <div class="col-md-6">
                                <label for="filterMonth" class="form-label stylish-label">
                                    <i class="bi bi-calendar-month me-2"></i> Bulan
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterMonth" class="form-select stylish-select">
                                        <option value="">Semua Bulan</option>
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?= $m ?>" <?= ($current_filters['month'] ?? '') == $m ? 'selected' : '' ?>>
                                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                            </div>

                            <!-- Filter Tahun -->
                            <div class="col-md-6">
                                <label for="filterYear" class="form-label stylish-label">
                                    <i class="bi bi-calendar me-2"></i> Tahun
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterYear" class="form-select stylish-select">
                                        <option value="">Semua Tahun</option>
                                        <?php $currentYear = date('Y'); ?>
                                        <?php for ($y = $currentYear; $y >= ($currentYear - 5); $y--): ?>
                                            <option value="<?= $y ?>" <?= ($current_filters['year'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Filter Options -->
                        <div class="quick-filter-section mt-4 pt-3 border-top">
                            <h6 class="text-light mb-3">Filter Cepat</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-outline-light quick-filter-btn <?= empty($current_filters['status']) && empty($current_filters['tipe']) && empty($current_filters['month']) && empty($current_filters['year']) ? 'active' : '' ?>"
                                    data-status="" data-tipe="" data-month="" data-year="">Semua</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn <?= ($current_filters['status'] ?? '') == 'pending' ? 'active' : '' ?>"
                                    data-status="pending" data-tipe="" data-month="" data-year="">Pending</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn <?= ($current_filters['status'] ?? '') == 'diterima' ? 'active' : '' ?>"
                                    data-status="diterima" data-tipe="" data-month="" data-year="">Diterima</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn <?= ($current_filters['month'] ?? '') == date('n') && ($current_filters['year'] ?? '') == date('Y') ? 'active' : '' ?>"
                                    data-status="" data-tipe="" data-month="<?= date('n') ?>" data-year="<?= date('Y') ?>">Bulan Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn <?= ($current_filters['year'] ?? '') == date('Y') && empty($current_filters['month']) ? 'active' : '' ?>"
                                    data-status="" data-tipe="" data-month="" data-year="<?= date('Y') ?>">Tahun Ini</button>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer stylish-modal-footer">
                        <button id="resetFilter" class="btn btn-outline-light stylish-reset-btn">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </button>
                        <button id="applyFilter" class="btn btn-gradient-primary stylish-apply-btn">
                            <i class="bi bi-check-lg me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pengajuan -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="pengajuanTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">User</th>
                        <th style="width: 15%;">Nominal</th>
                        <th>Keterangan</th>
                        <th style="width: 10%;">Tipe</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengajuan)): ?>
                        <?php $no = 1;
                        foreach ($pengajuan as $p): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= esc($p['username']) ?></td>
                                <td class="fw-bold text-success">
                                    Rp <?= number_format($p['nominal'], 0, ',', '.') ?>
                                </td>
                                <td class="text-light"><?= esc($p['keterangan']) ?></td>
                                <td>
                                    <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                        <span class="badge bg-info">Uang Sendiri</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Minta Admin</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                <td>
                                    <?php
                                    $status = strtolower($p['status']);
                                    $badge = [
                                        'pending'    => 'bg-warning text-dark',
                                        'diterima'   => 'bg-success',
                                        'ditolak'    => 'bg-danger',
                                        'selesai'    => 'bg-primary',
                                        'dibatalkan' => 'bg-secondary'
                                    ];
                                    ?>
                                    <span class="badge <?= $badge[$status] ?? 'bg-secondary' ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>

                                <!-- ============================= -->
                                <!--           AKSI BUTTONS        -->
                                <!-- ============================= -->
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <?php if ($p['status'] == 'pending'): ?>
                                            <!-- APPROVE / REJECT -->
                                            <button onclick="confirmApprove(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>', '<?= $p['tipe'] ?>', <?= $p['nominal'] ?>)"
                                                class="btn btn-sm btn-outline-success stylish-btn me-1"
                                                title="Setujui Pengajuan">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                            <button onclick="confirmReject(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>')"
                                                class="btn btn-sm btn-outline-danger stylish-btn"
                                                title="Tolak Pengajuan">
                                                <i class="bi bi-x-lg"></i>
                                            </button>

                                        <?php elseif ($p['status'] == 'diterima'): ?>
                                            <!-- LIHAT / PROSES / BATALKAN -->
                                            <?php if (!empty($p['file_nota'])): ?>
                                                <button class="btn btn-sm btn-outline-info stylish-btn me-1"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal<?= $p['id'] ?>"
                                                    title="Lihat Rincian Pengajuan">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                                    <button onclick="confirmProcessUangSendiri(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>', <?= $p['nominal'] ?>)"
                                                        class="btn btn-sm btn-outline-light stylish-btn me-1"
                                                        title="Proses Pengajuan">
                                                        <i class="bi bi-gear"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <form action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>"
                                                        method="post" style="display:inline;">
                                                        <button type="submit" class="btn btn-sm btn-outline-light stylish-btn me-1"
                                                            title="Proses Pengajuan">
                                                            <i class="bi bi-gear"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <!-- TOMBOL BATALKAN -->
                                                <a href="<?= site_url('admin/pengajuan/cancel/' . $p['id']) ?>"
                                                    class="btn btn-sm btn-outline-warning stylish-btn"
                                                    onclick="return confirm('Yakin ingin membatalkan pengajuan ini?')"
                                                    title="Batalkan Pengajuan">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                            <?php else: ?>
                                                <!-- UPLOAD NOTA -->
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-light stylish-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#processModal<?= $p['id'] ?>"
                                                    title="Upload Nota">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            <?php endif; ?>

                                        <?php elseif ($p['status'] == 'selesai' && $p['file_nota']): ?>
                                            <!-- LIHAT RINCIAN -->
                                            <button class="btn btn-sm btn-outline-info stylish-btn"
                                                data-bs-toggle="modal" data-bs-target="#detailModal<?= $p['id'] ?>"
                                                title="Lihat Rincian Pengajuan">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        <?php elseif ($p['status'] == 'dibatalkan'): ?>
                                            <!-- STATUS DIBATALKAN -->
                                            <span class="text-muted small fst-italic">Dibatalkan</span>

                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>


                            <!-- Modal Detail Pengajuan (Menggantikan modal lihat nota) -->
                            <?php if (($p['status'] == 'diterima' || $p['status'] == 'selesai') && !empty($p['file_nota'])): ?>
                                <div class="modal fade" id="detailModal<?= $p['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content stylish-modal">
                                            <div class="modal-header stylish-modal-header">
                                                <div class="d-flex align-items-center">
                                                    <div class="modal-icon me-3">
                                                        <i class="bi bi-receipt-cutoff"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title mb-0">Detail Pengajuan</h5>
                                                        <p class="modal-subtitle mb-0">ID: #<?= $p['id'] ?></p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body stylish-modal-body">
                                                <!-- Info Pengajuan -->
                                                <div class="info-card mb-4">
                                                    <h6 class="section-title mb-3">
                                                        <i class="bi bi-card-checklist me-2"></i>Informasi Pengajuan
                                                    </h6>
                                                    <div class="row g-3">
                                                        <!-- Baris 1: User dan Nominal -->
                                                        <div class="col-md-6">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-person-circle"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Pengaju</div>
                                                                    <div class="info-value fw-semibold"><?= esc($p['username']) ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-currency-dollar"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Nominal</div>
                                                                    <div class="info-value text-success fw-bold">Rp <?= number_format($p['nominal'], 0, ',', '.') ?></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Baris 2: Status dan Tipe -->
                                                        <div class="col-md-6">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-hourglass"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Status</div>
                                                                    <div class="info-value">
                                                                        <?php
                                                                        $status = strtolower($p['status']);
                                                                        $badge = [
                                                                            'pending' => 'bg-warning text-dark',
                                                                            'diterima' => 'bg-success',
                                                                            'ditolak' => 'bg-danger',
                                                                            'selesai' => 'bg-primary'
                                                                        ];
                                                                        ?>
                                                                        <span class="badge <?= $badge[$status] ?? 'bg-secondary' ?>">
                                                                            <i class="bi 
                                                    <?= $status == 'pending' ? 'bi-clock' : ($status == 'diterima' ? 'bi-check-circle' : ($status == 'ditolak' ? 'bi-x-circle' : ($status == 'selesai' ? 'bi-check-all' : 'bi-dash-circle'))) ?> me-1">
                                                                            </i>
                                                                            <?= ucfirst($p['status']) ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-tag"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Tipe Pengajuan</div>
                                                                    <div class="info-value">
                                                                        <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                                                            <span class="badge bg-info">
                                                                                <i class="bi bi-wallet2 me-1"></i>Uang Sendiri
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <span class="badge bg-primary">
                                                                                <i class="bi bi-person-gear me-1"></i>Minta Admin
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Baris 3: Tanggal Pengajuan dan Konfirmasi -->
                                                        <div class="col-md-6">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-calendar-plus"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Tanggal Dibuat</div>
                                                                    <div class="info-value"><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-calendar-check"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Tanggal Dikonfirmasi</div>
                                                                    <div class="info-value">
                                                                        <?php if ($p['confirm_at']): ?>
                                                                            <?= date('d/m/Y H:i', strtotime($p['updated_at'])) ?>
                                                                        <?php else: ?>
                                                                            <span class="text-muted">-</span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Baris 4: Keterangan (Full Width) -->
                                                        <div class="col-12">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-chat-left-text"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">Keterangan</div>
                                                                    <div class="info-value">
                                                                        <?php if (!empty($p['keterangan'])): ?>
                                                                            <?= esc($p['keterangan']) ?>
                                                                        <?php else: ?>
                                                                            <span class="text-muted">-</span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- File Nota -->
                                                <div class="file-section">
                                                    <h6 class="section-title mb-3">
                                                        <i class="bi bi-paperclip me-2"></i>File Nota
                                                    </h6>
                                                    <div class="file-preview-card">
                                                        <div class="preview-header">
                                                            <div class="file-info">
                                                                <div class="file-icon">
                                                                    <?php
                                                                    $fileExtension = pathinfo($p['file_nota'], PATHINFO_EXTENSION);
                                                                    $iconClass = 'bi-file-earmark-text';
                                                                    $fileType = 'Dokumen';

                                                                    if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
                                                                        $iconClass = 'bi-file-image';
                                                                        $fileType = 'Gambar';
                                                                    } elseif (strtolower($fileExtension) === 'pdf') {
                                                                        $iconClass = 'bi-file-pdf';
                                                                        $fileType = 'PDF';
                                                                    }
                                                                    ?>
                                                                    <i class="bi <?= $iconClass ?>"></i>
                                                                </div>
                                                                <div class="file-details">
                                                                    <div class="file-name fw-semibold"><?= $p['file_nota'] ?></div>
                                                                    <div class="file-type text-muted small"><?= $fileType ?> • <?= strtoupper($fileExtension) ?></div>
                                                                </div>
                                                            </div>
                                                            <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                                target="_blank"
                                                                class="btn btn-primary btn-sm stylish-btn">
                                                                <i class="bi bi-download me-1"></i> Unduh
                                                            </a>
                                                        </div>
                                                        <div class="preview-content mt-3">
                                                            <?php if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                                <!-- Preview Gambar -->
                                                                <div class="image-preview text-center">
                                                                    <img src="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                                        alt="Nota Pengajuan"
                                                                        class="img-fluid rounded shadow-sm"
                                                                        style="max-height: 400px; object-fit: contain;"
                                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div class="no-preview text-center py-4" style="display: none;">
                                                                        <i class="bi bi-file-image display-4 text-muted mb-3"></i>
                                                                        <p class="text-muted">Gambar tidak dapat dimuat</p>
                                                                        <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                                            target="_blank"
                                                                            class="btn btn-outline-primary btn-sm">
                                                                            Lihat File
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php elseif (strtolower($fileExtension) === 'pdf'): ?>
                                                                <!-- Preview PDF (Embed) -->
                                                                <div class="pdf-preview position-relative">
                                                                    <iframe src="<?= base_url('uploads/nota/' . $p['file_nota']) ?>#view=fitH"
                                                                        width="100%"
                                                                        height="400"
                                                                        style="border: none; border-radius: 8px;"
                                                                        class="shadow-sm">
                                                                        Browser Anda tidak mendukung preview PDF.
                                                                    </iframe>
                                                                    <div class="position-absolute top-50 start-50 translate-middle opacity-0 hover-opacity-100 transition-opacity">
                                                                        <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                                            target="_blank"
                                                                            class="btn btn-primary">
                                                                            Buka di Tab Baru
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <!-- File tidak dapat dipreview -->
                                                                <div class="no-preview text-center py-4">
                                                                    <i class="bi bi-file-earmark-text display-4 text-muted mb-3"></i>
                                                                    <p class="text-muted">Preview tidak tersedia untuk file ini</p>
                                                                    <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                                        target="_blank"
                                                                        class="btn btn-primary">
                                                                        <i class="bi bi-download me-1"></i> Unduh File
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer stylish-modal-footer">
                                                <button type="button" class="btn btn-secondary stylish-reset-btn" data-bs-dismiss="modal">
                                                    <i class="bi bi-x-lg me-1"></i> Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!-- Modal Upload Nota (Tetap sama) -->
                            <?php if ($p['status'] == 'diterima' && empty($p['file_nota'])): ?>
                                <div class="modal fade" id="processModal<?= $p['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content stylish-modal">
                                            <div class="modal-header stylish-modal-header">
                                                <div class="d-flex align-items-center">
                                                    <div class="modal-icon me-3">
                                                        <i class="bi bi-cloud-upload-fill"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="modal-title mb-0">Upload Nota Pengajuan</h5>
                                                        <p class="modal-subtitle mb-0">Lengkapi dokumen untuk pengajuan #<?= $p['id'] ?></p>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="post" action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>" enctype="multipart/form-data">
                                                <div class="modal-body stylish-modal-body">
                                                    <!-- Info Pengajuan -->
                                                    <div class="info-card mb-4">
                                                        <h6 class="section-title mb-3">
                                                            <i class="bi bi-info-circle me-2"></i>Detail Pengajuan
                                                        </h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <div class="info-item">
                                                                    <div class="info-icon">
                                                                        <i class="bi bi-person"></i>
                                                                    </div>
                                                                    <div class="info-content">
                                                                        <div class="info-label">User</div>
                                                                        <div class="info-value"><?= esc($p['username']) ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="info-item">
                                                                    <div class="info-icon">
                                                                        <i class="bi bi-cash-coin"></i>
                                                                    </div>
                                                                    <div class="info-content">
                                                                        <div class="info-label">Nominal</div>
                                                                        <div class="info-value text-success">Rp <?= number_format($p['nominal'], 0, ',', '.') ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="info-item">
                                                                    <div class="info-icon">
                                                                        <i class="bi bi-chat-left-text"></i>
                                                                    </div>
                                                                    <div class="info-content">
                                                                        <div class="info-label">Keterangan</div>
                                                                        <div class="info-value"><?= esc($p['keterangan']) ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="info-item">
                                                                    <div class="info-icon">
                                                                        <i class="bi bi-tag"></i>
                                                                    </div>
                                                                    <div class="info-content">
                                                                        <div class="info-label">Tipe</div>
                                                                        <div class="info-value">
                                                                            <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                                                                <span class="badge bg-info">Uang Sendiri</span>
                                                                            <?php else: ?>
                                                                                <span class="badge bg-primary">Minta Admin</span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="info-item">
                                                                    <div class="info-icon">
                                                                        <i class="bi bi-calendar"></i>
                                                                    </div>
                                                                    <div class="info-content">
                                                                        <div class="info-label">Tanggal</div>
                                                                        <div class="info-value"><?= date('d/m/Y', strtotime($p['created_at'])) ?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Upload Section -->
                                                    <div class="upload-section">
                                                        <h6 class="section-title mb-3">
                                                            <i class="bi bi-file-earmark-arrow-up me-2"></i>Upload Dokumen
                                                        </h6>

                                                        <div class="file-upload-area" id="uploadArea<?= $p['id'] ?>">
                                                            <div class="upload-placeholder">
                                                                <i class="bi bi-cloud-upload display-4 mb-3 upload-icon"></i>
                                                                <h6 class="upload-title">Drop file here or click to upload</h6>
                                                                <p class="upload-subtitle">Format: JPG, PNG, PDF (Maks. 5MB)</p>
                                                                <div class="upload-features">
                                                                    <span class="feature-badge">
                                                                        <i class="bi bi-check-lg me-1"></i>Secure
                                                                    </span>
                                                                    <span class="feature-badge">
                                                                        <i class="bi bi-check-lg me-1"></i>Fast
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <input type="file" class="file-input" name="file_nota"
                                                                accept=".jpg,.jpeg,.png,.pdf" required
                                                                id="fileInput<?= $p['id'] ?>">
                                                        </div>

                                                        <!-- File Preview -->
                                                        <div class="file-preview mt-3 d-none" id="filePreview<?= $p['id'] ?>">
                                                            <div class="preview-card">
                                                                <div class="preview-icon">
                                                                    <i class="bi bi-file-earmark-text"></i>
                                                                </div>
                                                                <div class="preview-info flex-grow-1">
                                                                    <div class="file-name text-light fw-medium"></div>
                                                                    <div class="file-size text-muted small"></div>
                                                                    <div class="file-status text-success small">
                                                                        <i class="bi bi-check-circle-fill me-1"></i>Ready to upload
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-sm btn-outline-danger remove-file" title="Remove file">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Upload Progress -->
                                                        <div class="upload-progress mt-3 d-none" id="uploadProgress<?= $p['id'] ?>">
                                                            <div class="progress-bar-container">
                                                                <div class="progress-info d-flex justify-content-between mb-2">
                                                                    <span class="progress-status">Uploading...</span>
                                                                    <span class="progress-percent">0%</span>
                                                                </div>
                                                                <div class="progress-bar">
                                                                    <div class="progress-fill"></div>
                                                                </div>
                                                                <div class="progress-details mt-2 text-center">
                                                                    <small class="text-muted">Please wait while we process your file</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Information Box -->
                                                    <div class="info-box mt-4">
                                                        <div class="info-box-header">
                                                            <i class="bi bi-info-circle-fill me-2"></i>
                                                            <span class="fw-medium">Informasi Penting</span>
                                                        </div>
                                                        <div class="info-box-content">
                                                            <ul class="info-list">
                                                                <li>
                                                                    <i class="bi bi-check-circle text-success me-2"></i>
                                                                    Pastikan file nota jelas dan terbaca
                                                                </li>
                                                                <li>
                                                                    <i class="bi bi-check-circle text-success me-2"></i>
                                                                    File akan diverifikasi sebelum diproses
                                                                </li>
                                                                <li>
                                                                    <i class="bi bi-check-circle text-success me-2"></i>
                                                                    Proses mungkin memakan waktu beberapa menit
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer stylish-modal-footer">
                                                    <button type="button" class="btn btn-outline-light stylish-reset-btn" data-bs-dismiss="modal">
                                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                                    </button>
                                                    <button type="submit" class="btn btn-gradient-primary stylish-apply-btn" id="submitBtn<?= $p['id'] ?>" disabled>
                                                        <i class="bi bi-cloud-upload me-1"></i> Upload & Proses
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox display-1 text-light"></i>
                                    <h5 class="mt-3">Belum ada data pengajuan</h5>
                                    <p class="text-muted">Semua pengajuan user akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2" id="paginationContainer">
        <button id="prevPage" class="btn btn-sm btn-outline-light stylish-btn" disabled>
            <i class="bi bi-chevron-left"></i> Prev
        </button>

        <div id="paginationInfo" class="text-white small text-center flex-grow-1"></div>

        <button id="nextPage" class="btn btn-sm btn-outline-light stylish-btn">
            Next <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<!-- Tambahkan CSS untuk info cards -->
<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
    }

    .table thead {
        background: rgba(67, 97, 238, 0.15);
        border-bottom: 2px solid rgba(67, 97, 238, 0.3);
    }

    .table tbody tr:hover {
        background: rgba(67, 97, 238, 0.08) !important;
        transform: translateX(2px);
        transition: all 0.3s ease;
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 4px 14px;
        transition: 0.3s;
        margin: 0 2px;
    }

    .stylish-btn:hover {
        background: #4361ee;
        border-color: #4361ee;
        color: #fff;
        box-shadow: 0 0 8px rgba(67, 97, 238, 0.8);
        transform: translateY(-1px);
    }

    .modern-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 12px;
        transition: 0.3s;
    }

    .modern-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 8px rgba(67, 97, 238, 0.6);
    }

    .modern-search {
        position: relative;
    }

    .modern-search i {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        color: #aaa;
    }

    .modern-search input {
        padding-left: 38px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .modern-search input::placeholder {
        color: #bbb;
        font-style: italic;
    }

    .modern-search input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 10px rgba(67, 97, 238, 0.6);
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .text-success {
        color: #06d6a0 !important;
    }

    .text-steam-blue {
        color: #66c0f4;
    }

    .stylish-alert {
        border-radius: 12px;
        font-weight: 500;
    }

    /* Hide pagination when not needed */
    .pagination-hidden {
        display: none !important;
    }

    /* Styling untuk Modal Filter */
    .stylish-modal {
        background: linear-gradient(135deg, rgba(40, 40, 60, 0.95) 0%, rgba(30, 30, 50, 0.95) 100%);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        overflow: hidden;
    }

    .stylish-modal-header {
        background: #000;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
    }

    .modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        background: rgba(67, 97, 238, 0.2);
        border-radius: 12px;
        font-size: 1.5rem;
        color: #4361ee;
    }

    .modal-subtitle {
        color: #aaa;
        font-size: 0.85rem;
    }

    .stylish-modal-body {
        padding: 1.5rem;
        background: #2b2b2b;
    }

    .stylish-label {
        color: #e0e0e0;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .select-wrapper {
        position: relative;
    }

    .stylish-select {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .stylish-select:focus {
        background: rgba(255, 255, 255, 0.12);
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.25);
        color: #fff;
    }

    .select-arrow {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        pointer-events: none;
    }

    .quick-filter-section {
        border-top-color: rgba(255, 255, 255, 0.1) !important;
    }

    .quick-filter-btn {
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }

    .quick-filter-btn:hover,
    .quick-filter-btn.active {
        background: #4361ee;
        border-color: #4361ee;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
    }

    .stylish-modal-footer {
        background: #1e1e1e;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1.2rem 1.5rem;
    }

    .stylish-reset-btn,
    .stylish-apply-btn {
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .stylish-reset-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .stylish-apply-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(13, 110, 253, 0.4);
    }

    .stylish-filter-btn {
        border-radius: 10px;
        padding: 0.55rem 1.1rem;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .stylish-filter-btn i {
        font-size: 1rem;
    }

    .stylish-filter-btn:hover {
        background: #4361ee;
        color: #fff;
        border-color: #4361ee;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(67, 97, 238, 0.25);
    }

    /* === SweetAlert2 Stylish Modal untuk Konfirmasi === */
    .swal2-popup.stylish-modal {
        background: linear-gradient(135deg, rgba(40, 40, 60, 0.98) 0%, rgba(30, 30, 50, 0.98) 100%);
        border: 1px solid rgba(67, 97, 238, 0.3);
        border-radius: 16px;
        padding: 0;
        color: #fff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(15px);
        overflow: hidden;
    }

    /* Header Style */
    .swal2-popup.stylish-modal .swal2-header {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.2) 0%, rgba(67, 97, 238, 0.1) 100%);
        border-bottom: 1px solid rgba(67, 97, 238, 0.3);
        margin: 0;
        padding: 1.5rem 1.5rem 1rem;
    }

    .swal2-popup.stylish-modal .modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        margin-right: 1rem;
    }

    .swal2-popup.stylish-modal .approve-icon {
        background: linear-gradient(135deg, #06d6a0, #05c293);
    }

    .swal2-popup.stylish-modal .reject-icon {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    }

    .swal2-popup.stylish-modal .process-icon {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
    }

    .swal2-popup.stylish-modal .modal-icon i {
        color: #fff;
        font-size: 1.5rem;
    }

    .swal2-popup.stylish-modal .swal2-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }

    .swal2-popup.stylish-modal .modal-subtitle {
        color: #aaa;
        font-size: 0.9rem;
        margin: 0.25rem 0 0 0;
    }

    /* Body Style */
    .swal2-popup.stylish-modal .swal2-html-container {
        margin: 0;
        padding: 1.5rem;
        color: #e0e0e0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .swal2-popup.stylish-modal .info-highlight {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
    }

    .swal2-popup.stylish-modal .info-highlight i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    .swal2-popup.stylish-modal .user-highlight {
        background: rgba(67, 97, 238, 0.1);
        border: 1px solid rgba(67, 97, 238, 0.3);
    }

    .swal2-popup.stylish-modal .user-highlight i {
        color: #4361ee;
    }

    .swal2-popup.stylish-modal .tipe-highlight {
        background: rgba(102, 192, 244, 0.1);
        border: 1px solid rgba(102, 192, 244, 0.3);
    }

    .swal2-popup.stylish-modal .tipe-highlight i {
        color: #66c0f4;
    }

    .swal2-popup.stylish-modal .nominal-highlight {
        background: rgba(6, 214, 160, 0.1);
        border: 1px solid rgba(6, 214, 160, 0.3);
        color: #06d6a0;
        font-weight: bold;
    }

    .swal2-popup.stylish-modal .nominal-highlight i {
        color: #06d6a0;
    }

    .swal2-popup.stylish-modal .warning-highlight {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        color: #ffd166;
    }

    .swal2-popup.stylish-modal .warning-highlight i {
        color: #ffd166;
    }

    .swal2-popup.stylish-modal .saldo-highlight {
        background: rgba(6, 214, 160, 0.1);
        border: 1px solid rgba(6, 214, 160, 0.3);
        color: #06d6a0;
        font-weight: bold;
    }

    .swal2-popup.stylish-modal .saldo-highlight i {
        color: #06d6a0;
    }

    .swal2-popup.stylish-modal .danger-highlight {
        background: rgba(255, 107, 107, 0.1);
        border: 1px solid rgba(255, 107, 107, 0.3);
        color: #ff6b6b;
    }

    .swal2-popup.stylish-modal .danger-highlight i {
        color: #ff6b6b;
    }

    .swal2-popup.stylish-modal .warning-text {
        color: #ffd166;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
    }

    .swal2-popup.stylish-modal .warning-text i {
        margin-right: 0.5rem;
    }

    /* Footer & Buttons */
    .swal2-popup.stylish-modal .swal2-actions {
        margin: 0;
        padding: 1rem 1.5rem 1.5rem;
        gap: 0.75rem;
    }

    .swal2-popup.stylish-modal .swal2-confirm {
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .swal2-popup.stylish-modal .approve-confirm {
        background: linear-gradient(135deg, #06d6a0, #05c293);
    }

    .swal2-popup.stylish-modal .reject-confirm {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    }

    .swal2-popup.stylish-modal .process-confirm {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
    }

    .swal2-popup.stylish-modal .swal2-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .swal2-popup.stylish-modal .approve-confirm:hover {
        box-shadow: 0 6px 15px rgba(6, 214, 160, 0.4);
    }

    .swal2-popup.stylish-modal .reject-confirm:hover {
        box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
    }

    .swal2-popup.stylish-modal .process-confirm:hover {
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    .swal2-popup.stylish-modal .swal2-cancel {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .swal2-popup.stylish-modal .swal2-cancel:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #3a56d4, #2f45b8);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    /* ==================== */
    /* STYLING MODAL UPLOAD */
    /* ==================== */

    /* Section Title */
    .section-title {
        color: #66c0f4;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    /* Info Card */
    .info-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 36px;
        height: 36px;
        background: rgba(67, 97, 238, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: #4361ee;
        font-size: 1.1rem;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        color: #aaa;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .info-value {
        color: #fff;
        font-size: 0.95rem;
        font-weight: 400;
    }

    /* Upload Section */
    .upload-section {
        margin-top: 2rem;
    }

    .file-upload-area {
        border: 2px dashed rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.02);
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover {
        border-color: #4361ee;
        background: rgba(67, 97, 238, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(67, 97, 238, 0.15);
    }

    .file-upload-area.dragover {
        border-color: #06d6a0;
        background: rgba(6, 214, 160, 0.08);
        transform: scale(1.02);
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .upload-placeholder {
        pointer-events: none;
    }

    .upload-icon {
        color: #666;
        transition: all 0.3s ease;
    }

    .file-upload-area:hover .upload-icon {
        color: #4361ee;
        transform: translateY(-5px);
    }

    .upload-title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .upload-subtitle {
        color: #888;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .upload-features {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .feature-badge {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        color: #aaa;
        display: flex;
        align-items: center;
    }

    .feature-badge i {
        font-size: 0.7rem;
        color: #06d6a0;
    }

    /* File Preview */
    .file-preview {
        animation: slideInDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .preview-card {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1.25rem;
        gap: 1rem;
        transition: all 0.3s ease;
    }

    .preview-card:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.12);
        transform: translateY(-2px);
    }

    .preview-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #4361ee, #4cc9f0);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .preview-info {
        flex-grow: 1;
        min-width: 0;
    }

    .file-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-size {
        color: #888;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }

    .file-status {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
    }

    .file-status i {
        font-size: 0.7rem;
    }

    .remove-file {
        border-radius: 8px;
        padding: 0.5rem 0.6rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .remove-file:hover {
        background: #dc3545;
        border-color: #dc3545;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Upload Progress */
    .upload-progress {
        animation: fadeIn 0.4s ease;
    }

    .progress-bar-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1.5rem;
    }

    .progress-info {
        margin-bottom: 1rem;
    }

    .progress-status {
        color: #fff;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .progress-percent {
        color: #06d6a0;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        overflow: hidden;
        position: relative;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #06d6a0, #4cc9f0);
        border-radius: 4px;
        width: 0%;
        transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }

    .progress-details {
        margin-top: 0.75rem;
    }

    /* Information Box */
    .info-box {
        background: rgba(255, 193, 7, 0.05);
        border: 1px solid rgba(255, 193, 7, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
    }

    .info-box-header {
        color: #ffc107;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .info-box-content {
        color: #ffd166;
    }

    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-list li {
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .info-list li i {
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    /* Animations */
    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Badge styling dalam modal */
    .modal .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
    }

    /* Styling khusus untuk modal rincian */
    .file-section {
        margin-top: 2rem;
    }

    .file-preview-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .preview-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .file-info {
        display: flex;
        align-items: center;
        flex-grow: 1;
    }

    .file-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #4361ee, #4cc9f0);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .file-details {
        flex-grow: 1;
    }

    .file-name {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .file-type {
        color: #aaa;
        font-size: 0.85rem;
    }

    .preview-content {
        border-radius: 8px;
        overflow: hidden;
    }

    .image-preview {
        text-align: center;
        background: rgba(0, 0, 0, 0.3);
        padding: 1rem;
        border-radius: 8px;
    }

    .pdf-preview {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 8px;
        overflow: hidden;
    }

    .no-preview {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 2rem;
    }

    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        font-size: 1.8rem;
    }

    .card-title {
        font-size: 0.9rem;
        font-weight: 500;
        color: #aaa;
    }

    .card-value {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .card-footer {
        border-top-color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Warna untuk card icons */
    .text-primary {
        color: #4361ee !important;
    }

    .text-warning {
        color: #ffd166 !important;
    }

    .text-success {
        color: #06d6a0 !important;
    }

    .text-info {
        color: #118ab2 !important;
    }
</style>

<!-- Script lainnya tetap sama -->
<script>
    // ===========================
    // FILE UPLOAD FUNCTIONALITY
    // ===========================

    function initFileUploadModal(modalId) {
        const uploadArea = document.getElementById(`uploadArea${modalId}`);
        const fileInput = document.getElementById(`fileInput${modalId}`);
        const filePreview = document.getElementById(`filePreview${modalId}`);
        const fileName = filePreview.querySelector('.file-name');
        const fileSize = filePreview.querySelector('.file-size');
        const removeBtn = filePreview.querySelector('.remove-file');
        const uploadProgress = document.getElementById(`uploadProgress${modalId}`);
        const progressFill = uploadProgress.querySelector('.progress-fill');
        const progressPercent = uploadProgress.querySelector('.progress-percent');
        const progressStatus = uploadProgress.querySelector('.progress-status');
        const submitBtn = document.getElementById(`submitBtn${modalId}`);

        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            uploadArea.classList.add('dragover');
        }

        function unhighlight() {
            uploadArea.classList.remove('dragover');
        }

        // Handle file drop
        uploadArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // Handle file input change
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];

                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Hanya file JPG, PNG, dan PDF yang diperbolehkan.',
                        confirmButtonText: 'Mengerti',
                        background: '#1e1e1e',
                        color: '#fff'
                    });
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Ukuran file maksimal 5MB.',
                        confirmButtonText: 'Mengerti',
                        background: '#1e1e1e',
                        color: '#fff'
                    });
                    return;
                }

                // Show file preview
                showFilePreview(file);
            }
        }

        function showFilePreview(file) {
            const fileSizeFormatted = formatFileSize(file.size);

            fileName.textContent = file.name;
            fileSize.textContent = fileSizeFormatted;

            filePreview.classList.remove('d-none');
            uploadProgress.classList.add('d-none');
            submitBtn.disabled = false;
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Remove file
        removeBtn.addEventListener('click', function() {
            fileInput.value = '';
            filePreview.classList.add('d-none');
            uploadProgress.classList.add('d-none');
            submitBtn.disabled = true;
        });

        // Initialize submit button as disabled
        submitBtn.disabled = true;
    }

    // Initialize file upload for each modal when shown
    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('[id^="processModal"]');
        modals.forEach(modal => {
            const modalId = modal.id.replace('processModal', '');
            initFileUploadModal(modalId);
        });
    });

    // ===========================
    // EXISTING FUNCTIONALITY
    // ===========================

    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("pengajuanTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const searchInput = document.getElementById("searchInput");
    const paginationContainer = document.getElementById("paginationContainer");

    // AMBIL SALDO DARI PHP
    const saldoAkhir = <?= $saldo_akhir ?? 0 ?>;

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(table.getElementsByTagName("tr"));
    }

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        return getRows().filter(row => {
            if (row.cells.length < 8) return false;
            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const nominal = row.cells[2]?.textContent.toLowerCase() || "";
            const keterangan = row.cells[3]?.textContent.toLowerCase() || "";
            const tipe = row.cells[4]?.textContent.toLowerCase() || "";
            const status = row.cells[6]?.textContent.toLowerCase() || "";

            return username.includes(search) ||
                nominal.includes(search) ||
                keterangan.includes(search) ||
                tipe.includes(search) ||
                status.includes(search);
        });
    }

    function displayTable() {
        const allRows = getRows();
        const filteredRows = filterRows();
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        allRows.forEach(row => row.style.display = "none");

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        for (let i = start; i < end && i < totalRows; i++) {
            filteredRows[i].style.display = "";
        }

        paginationInfo.innerHTML = totalRows > 0 ?
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} pengajuan | Halaman ${currentPage} dari ${totalPages}` :
            "Tidak ada data ditemukan";

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        if (totalRows <= rowsPerPage) {
            paginationContainer.classList.add('pagination-hidden');
        } else {
            paginationContainer.classList.remove('pagination-hidden');
        }
    }

    rowsPerPageSelect.addEventListener("change", () => {
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        displayTable();
    });

    searchInput.addEventListener("input", () => {
        currentPage = 1;
        displayTable();
    });

    prevBtn.addEventListener("click", () => {
        if (currentPage > 1) {
            currentPage--;
            displayTable();
        }
    });

    nextBtn.addEventListener("click", () => {
        const totalPages = Math.ceil(filterRows().length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayTable();
        }
    });

    // ===========================
    // FILTER FUNCTIONALITY
    // ===========================
    document.getElementById('applyFilter').addEventListener('click', function() {
        const status = document.getElementById('filterStatus').value;
        const tipe = document.getElementById('filterTipe').value;
        const month = document.getElementById('filterMonth').value;
        const year = document.getElementById('filterYear').value;

        let url = '<?= site_url('admin/pengajuan') ?>';
        const params = [];
        if (status) params.push('status=' + status);
        if (tipe) params.push('tipe=' + tipe);
        if (month) params.push('month=' + month);
        if (year) params.push('year=' + year);
        if (params.length) url += '?' + params.join('&');

        window.location.href = url;
    });

    document.getElementById('resetFilter').addEventListener('click', function() {
        window.location.href = '<?= site_url('admin/pengajuan') ?>';
    });

    // Quick filter buttons
    document.querySelectorAll('.quick-filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const status = this.getAttribute('data-status');
            const tipe = this.getAttribute('data-tipe');
            const month = this.getAttribute('data-month');
            const year = this.getAttribute('data-year');

            document.getElementById('filterStatus').value = status;
            document.getElementById('filterTipe').value = tipe;
            document.getElementById('filterMonth').value = month;
            document.getElementById('filterYear').value = year;

            // Remove active class from all buttons
            document.querySelectorAll('.quick-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');
        });
    });

    // Set active class on current filter
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const tipe = urlParams.get('tipe');
        const month = urlParams.get('month');
        const year = urlParams.get('year');

        // Set filter values from URL
        if (status) document.getElementById('filterStatus').value = status;
        if (tipe) document.getElementById('filterTipe').value = tipe;
        if (month) document.getElementById('filterMonth').value = month;
        if (year) document.getElementById('filterYear').value = year;

        // Set active class on quick filter buttons
        document.querySelectorAll('.quick-filter-btn').forEach(button => {
            const btnStatus = button.getAttribute('data-status');
            const btnTipe = button.getAttribute('data-tipe');
            const btnMonth = button.getAttribute('data-month');
            const btnYear = button.getAttribute('data-year');

            if (btnStatus === (status || '') &&
                btnTipe === (tipe || '') &&
                btnMonth === (month || '') &&
                btnYear === (year || '')) {
                button.classList.add('active');
            }
        });

        // Initialize table display
        displayTable();
    });

    // ===========================
    // FUNGSI POST DINAMIS
    // ===========================
    function postToProcess(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "<?= site_url('admin/pengajuan/process/') ?>" + id;
        document.body.appendChild(form);
        form.submit();
    }

    // Konfirmasi Approve dengan Validasi Saldo
    function confirmApprove(id, username, nominal, keterangan, tipe, nominalAngka) {
        // CEK SALDO TERLEBIH DAHULU
        if (nominalAngka > saldoAkhir) {
            Swal.fire({
                html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon me-3 reject-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <div class="swal2-title">Saldo Tidak Mencukupi</div>
                            <div class="modal-subtitle">Pengajuan tidak dapat disetujui</div>
                        </div>
                    </div>

                    <div class="swal2-html-container mt-3">
                        <p>Saldo kas saat ini tidak mencukupi untuk menyetujui pengajuan berikut:</p>
                        <div class="info-highlight user-highlight">
                            <i class="bi bi-person-fill"></i>
                            <span class="fw-bold">${username}</span>
                        </div>
                        <div class="info-highlight danger-highlight">
                            <i class="bi bi-exclamation-circle"></i>
                            <span class="fw-bold">Nominal: ${nominal}</span>
                        </div>
                        <div class="info-highlight nominal-highlight">
                            <i class="bi bi-wallet2"></i>
                            <span>Saldo Tersedia: Rp ${saldoAkhir.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="info-highlight warning-highlight">
                            <i class="bi bi-dash-circle"></i>
                            <span class="fw-bold">Kekurangan: Rp ${(nominalAngka - saldoAkhir).toLocaleString('id-ID')}</span>
                        </div>
                        <div class="warning-text">
                            <i class="bi bi-info-circle"></i>
                            <span>Silakan tambah saldo kas terlebih dahulu atau tolak pengajuan ini.</span>
                        </div>
                    </div>
                </div>
            `,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Mengerti',
                cancelButtonText: '<i class="bi bi-arrow-left me-1"></i> Batal',
                customClass: {
                    popup: 'stylish-modal',
                    header: 'd-none',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm reject-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                hideClass: {
                    popup: '',
                    backdrop: ''
                }
            });
            return;
        }

        // Jika saldo cukup, lanjutkan proses approval normal
        let tipeInfo = tipe === 'uang_sendiri' ? 'Uang Sendiri' : 'Minta Admin';

        Swal.fire({
            html: `
            <div class="swal2-custom">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3 approve-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="swal2-title">Setujui Pengajuan</div>
                        <div class="modal-subtitle">Konfirmasi persetujuan pengajuan kas</div>
                    </div>
                </div>

                <div class="swal2-html-container mt-3">
                    <p>Apakah Anda yakin ingin menyetujui pengajuan berikut:</p>
                    <div class="info-highlight user-highlight">
                        <i class="bi bi-person-fill"></i>
                        <span class="fw-bold">${username}</span>
                    </div>
                    <div class="info-highlight tipe-highlight">
                        <i class="bi bi-tag-fill"></i>
                        <span class="fw-bold">${tipeInfo}</span>
                    </div>
                    <div class="info-highlight nominal-highlight">
                        <i class="bi bi-cash-coin"></i>
                        <span>${nominal}</span>
                    </div>
                    <div class="info-highlight">
                        <i class="bi bi-chat-left-text"></i>
                        <span>${keterangan}</span>
                    </div>
                    <div class="info-highlight saldo-highlight">
                        <i class="bi bi-calculator"></i>
                        <span class="fw-bold">Sisa Saldo: Rp ${(saldoAkhir - nominalAngka).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="warning-text">
                        <i class="bi bi-info-circle"></i>
                        <span>Status pengajuan akan berubah menjadi "Diterima"</span>
                    </div>
                </div>
            </div>
        `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Setujui',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm approve-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            hideClass: {
                popup: '',
                backdrop: ''
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyetujui...',
                    text: 'Pengajuan sedang diproses',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                window.location.href = "<?= site_url('admin/pengajuan/approve/') ?>" + id;
            }
        });
    }

    // Konfirmasi Reject
    function confirmReject(id, username, nominal, keterangan) {
        Swal.fire({
            html: `
            <div class="swal2-custom">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3 reject-icon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div>
                        <div class="swal2-title">Tolak Pengajuan</div>
                        <div class="modal-subtitle">Konfirmasi penolakan pengajuan kas</div>
                    </div>
                </div>

                <div class="swal2-html-container mt-3">
                    <p>Apakah Anda yakin ingin menolak pengajuan berikut:</p>
                    <div class="info-highlight user-highlight">
                        <i class="bi bi-person-fill"></i>
                        <span class="fw-bold">${username}</span>
                    </div>
                    <div class="info-highlight nominal-highlight">
                        <i class="bi bi-cash-coin"></i>
                        <span>${nominal}</span>
                    </div>
                    <div class="info-highlight">
                        <i class="bi bi-chat-left-text"></i>
                        <span>${keterangan}</span>
                    </div>
                    <div class="warning-text">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>Status pengajuan akan berubah menjadi "Ditolak" dan tidak dapat diubah.</span>
                    </div>
                </div>
            </div>
        `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Ya, Tolak',
            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i> Batal',
            customClass: {
                popup: 'stylish-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm reject-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            hideClass: {
                popup: '',
                backdrop: ''
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menolak...',
                    text: 'Pengajuan sedang diproses',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                window.location.href = "<?= site_url('admin/pengajuan/reject/') ?>" + id;
            }
        });
    }

    // Konfirmasi Process untuk Uang Sendiri
    function confirmProcessUangSendiri(id, username, nominal, keterangan, nominalAngka) {
        // CEK SALDO JUGA SAAT PROCESS
        if (nominalAngka > saldoAkhir) {
            Swal.fire({
                html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon me-3 reject-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <div class="swal2-title">Saldo Tidak Mencukupi</div>
                            <div class="modal-subtitle">Pengajuan tidak dapat diproses</div>
                        </div>
                    </div>

                    <div class="swal2-html-container mt-3">
                        <p>Saldo kas saat ini tidak mencukupi untuk memproses pengajuan berikut:</p>
                        <div class="info-highlight user-highlight">
                            <i class="bi bi-person-fill"></i>
                            <span class="fw-bold">${username} - Uang Sendiri</span>
                        </div>
                        <div class="info-highlight danger-highlight">
                            <i class="bi bi-exclamation-circle"></i>
                            <span class="fw-bold">Nominal: ${nominal}</span>
                        </div>
                        <div class="info-highlight nominal-highlight">
                            <i class="bi bi-wallet2"></i>
                            <span>Saldo Tersedia: Rp ${saldoAkhir.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="info-highlight warning-highlight">
                            <i class="bi bi-dash-circle"></i>
                            <span class="fw-bold">Kekurangan: Rp ${(nominalAngka - saldoAkhir).toLocaleString('id-ID')}</span>
                        </div>
                        <div class="warning-text">
                            <i class="bi bi-info-circle"></i>
                            <span>Silakan tambah saldo kas terlebih dahulu sebelum memproses pengajuan ini.</span>
                        </div>
                    </div>
                </div>
            `,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Mengerti',
                cancelButtonText: '<i class="bi bi-arrow-left me-1"></i> Batal',
                customClass: {
                    popup: 'stylish-modal',
                    header: 'd-none',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm reject-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false,
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                hideClass: {
                    popup: '',
                    backdrop: ''
                }
            });
            return;
        }

        Swal.fire({
            html: `
            <div class="swal2-custom">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3 process-icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                    <div>
                        <div class="swal2-title">Proses Pengajuan Uang Sendiri</div>
                        <div class="modal-subtitle">Konfirmasi pemotongan saldo kas</div>
                    </div>
                </div>

                <div class="swal2-html-container mt-3">
                    <p>Apakah Anda yakin ingin memproses pengajuan uang sendiri berikut:</p>
                    <div class="info-highlight user-highlight">
                        <i class="bi bi-person-fill"></i>
                        <span class="fw-bold">${username}</span>
                    </div>
                    <div class="info-highlight tipe-highlight">
                        <i class="bi bi-tag-fill"></i>
                        <span class="fw-bold">Uang Sendiri</span>
                    </div>
                    <div class="info-highlight nominal-highlight">
                        <i class="bi bi-cash-coin"></i>
                        <span>${nominal}</span>
                    </div>
                    <div class="info-highlight">
                        <i class="bi bi-chat-left-text"></i>
                        <span>${keterangan}</span>
                    </div>
                    <div class="info-highlight warning-highlight">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Akan langsung memotong saldo kas sebesar ${nominal}</span>
                    </div>
                    <div class="info-highlight saldo-highlight">
                        <i class="bi bi-calculator"></i>
                        <span class="fw-bold">Sisa Saldo: Rp ${(saldoAkhir - nominalAngka).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="warning-text">
                        <i class="bi bi-info-circle"></i>
                        <span>Status pengajuan akan berubah menjadi "Selesai" dan tidak dapat diubah kembali.</span>
                    </div>
                </div>
            </div>
        `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Proses',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm process-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            hideClass: {
                popup: '',
                backdrop: ''
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Pengajuan sedang diproses',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                postToProcess(id);
            }
        });
    }

    // Tampilkan tabel pertama kali
    displayTable();
</script>

<?= $this->endSection() ?>