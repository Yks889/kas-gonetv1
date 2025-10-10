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
                                <td>
                                    <?= $p['deadline'] ? date('d/m/Y', strtotime($p['deadline'])) : '-' ?>
                                </td>
                                <td>
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
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <?php if ($p['status'] == 'pending'): ?>
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
                                            <?php if (!empty($p['file_nota'])): ?>
                                                <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                    target="_blank" class="btn btn-sm btn-outline-info stylish-btn me-1"
                                                    title="Lihat Nota">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                                    <button onclick="confirmProcessUangSendiri(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>', <?= $p['nominal'] ?>)"
                                                        class="btn btn-sm btn-outline-light stylish-btn"
                                                        title="Proses Pengajuan">
                                                        <i class="bi bi-gear"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <form action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>"
                                                        method="post" style="display:inline;">
                                                        <button type="submit" class="btn btn-sm btn-outline-light stylish-btn"
                                                            title="Proses Pengajuan">
                                                            <i class="bi bi-gear"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-light stylish-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#processModal<?= $p['id'] ?>"
                                                    title="Upload Nota">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php elseif ($p['status'] == 'selesai' && $p['file_nota']): ?>
                                            <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                target="_blank" class="btn btn-sm btn-outline-info stylish-btn"
                                                title="Lihat Nota">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Upload Nota -->
                            <?php if ($p['status'] == 'diterima' && empty($p['file_nota'])): ?>
                                <div class="modal fade" id="processModal<?= $p['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-upload me-2"></i>Proses Pengajuan #<?= $p['id'] ?>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="post"
                                                action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>"
                                                enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-medium">Upload Nota/Struk</label>
                                                        <input type="file" class="form-control" name="file_nota"
                                                            accept=".jpg,.jpeg,.png,.pdf" required>
                                                        <div class="form-text">
                                                            Format: JPG, PNG, PDF (Maks. 5MB)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-check-lg me-1"></i>Proses
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

<!-- Styling tambahan -->
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
        background-color: #0d6efd;
        border: 1px solid #0d6efd;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        padding: 10px 20px;
        transition: 0.3s ease;
    }

    .btn-gradient-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
</style>

<script>
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