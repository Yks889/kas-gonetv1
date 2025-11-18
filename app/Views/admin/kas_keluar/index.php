<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-cash-stack me-2"></i> Data Kas Keluar
        </h1>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show stylish-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Info Cards -->
    <div class="row mb-4">
        <!-- Total Pengeluaran -->
        <div class="col-md-4 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-arrow-up-circle text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Total Pengeluaran</h5>
                        <h3 class="card-value text-danger mb-0">
                            Rp <?= isset($total_pengeluaran) ? number_format($total_pengeluaran, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Total semua pengeluaran yang telah disetujui
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Data Selesai -->
        <div class="col-md-4 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-check-circle text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Data Selesai</h5>
                        <h3 class="card-value text-success mb-0">
                            <?= isset($total_selesai) ? number_format($total_selesai, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Pengajuan yang sudah diproses dan selesai
                    </small>
                </div>
            </div>
        </div>

        <!-- Total User Mengajukan -->
        <div class="col-md-4 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-people text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">User Mengajukan</h5>
                        <h3 class="card-value text-warning mb-0">
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
                    placeholder="Cari user, keterangan, atau status...">
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
                                <h5 class="modal-title mb-0">Filter Kas Keluar</h5>
                                <p class="modal-subtitle mb-0">Saring data berdasarkan periode</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body stylish-modal-body">
                        <div class="row g-3">
                            <!-- Filter Bulan -->
                            <div class="col-md-6">
                                <label for="filterMonth" class="form-label stylish-label">
                                    <i class="bi bi-calendar-month me-2"></i> Bulan
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterMonth" class="form-select stylish-select">
                                        <option value="">Semua Bulan</option>
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?= $m ?>">
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
                                            <option value="<?= $y ?>"><?= $y ?></option>
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
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month="" data-year="">Semua</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month="<?= date('n') ?>" data-year="<?= date('Y') ?>">Bulan Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month="" data-year="<?= date('Y') ?>">Tahun Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month="" data-year="<?= date('Y') - 1 ?>">Tahun Lalu</button>
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

    <!-- Table Kas Keluar -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="kasKeluarTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">User</th>
                        <th style="width: 15%;">Nominal</th>
                        <th>Keterangan</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 18%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kas_keluar)): ?>
                        <?php $no = 1;
                        foreach ($kas_keluar as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['username'] ?? '-') ?></td>
                                <td class="fw-bold text-danger">
                                    Rp <?= isset($row['nominal']) ? number_format($row['nominal'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-light"><?= esc($row['keterangan'] ?? '-') ?></td>
                                <td><?= !empty($row['confirm_at']) ? date('d/m/Y H:i', strtotime($row['confirm_at'])) : '-' ?></td>
                                <td data-status="<?= strtolower($row['status'] ?? '') ?>">
                                    <?php
                                    $status = strtolower($row['status'] ?? '');
                                    $badge = [
                                        'pending'    => 'bg-warning text-dark',
                                        'diterima'   => 'bg-success',
                                        'ditolak'    => 'bg-danger',
                                        'selesai'    => 'bg-primary'
                                    ];
                                    ?>
                                    <span class="badge <?= $badge[$status] ?? 'bg-secondary' ?>">
                                        <?= ucfirst($row['status'] ?? '-') ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Tombol Detail -->
                                        <button class="btn btn-sm btn-outline-info stylish-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal<?= $row['pengajuan_id'] ?>"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Tombol Edit -->
                                        <a href="<?= site_url('admin/kas_keluar/edit/' . $row['pengajuan_id']) ?>"
                                            class="btn btn-sm btn-outline-light stylish-btn" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Detail untuk setiap data -->
                            <div class="modal fade" id="detailModal<?= $row['pengajuan_id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content stylish-modal">
                                        <div class="modal-header stylish-modal-header">
                                            <div class="d-flex align-items-center">
                                                <div class="modal-icon me-3">
                                                    <i class="bi bi-receipt-cutoff"></i>
                                                </div>
                                                <div>
                                                    <h5 class="modal-title mb-0">Detail Kas Keluar</h5>
                                                    <p class="modal-subtitle mb-0">ID: #<?= $row['pengajuan_id'] ?></p>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body stylish-modal-body">
                                            <!-- Info Pengajuan -->
                                            <div class="info-card mb-4">
                                                <h6 class="section-title mb-3">
                                                    <i class="bi bi-card-checklist me-2"></i>Informasi Pengeluaran
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
                                                                <div class="info-value fw-semibold"><?= esc($row['username'] ?? '-') ?></div>
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
                                                                <div class="info-value text-danger fw-bold">Rp <?= isset($row['nominal']) ? number_format($row['nominal'], 0, ',', '.') : '-' ?></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Baris 2: Status dan Tanggal Konfirmasi -->
                                                    <div class="col-md-6">
                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="bi bi-hourglass"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Status</div>
                                                                <div class="info-value">
                                                                    <?php
                                                                    $status = strtolower($row['status'] ?? '');
                                                                    $badge = [
                                                                        'pending'   => 'bg-warning text-dark',
                                                                        'diterima'  => 'bg-success',
                                                                        'ditolak'   => 'bg-danger',
                                                                        'selesai'   => 'bg-primary'
                                                                    ];
                                                                    ?>
                                                                    <span class="badge <?= $badge[$status] ?? 'bg-secondary' ?>">
                                                                        <i class="bi 
                                                <?= $status == 'pending' ? 'bi-clock' : ($status == 'diterima' ? 'bi-check-circle' : ($status == 'ditolak' ? 'bi-x-circle' : ($status == 'selesai' ? 'bi-check-all' : 'bi-dash-circle'))) ?> me-1">
                                                                        </i>
                                                                        <?= ucfirst($row['status'] ?? '-') ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="bi bi-calendar-check"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Tanggal Konfirmasi</div>
                                                                <div class="info-value">
                                                                    <?php if (!empty($row['confirm_at'])): ?>
                                                                        <?= date('d/m/Y H:i', strtotime($row['confirm_at'])) ?>
                                                                    <?php else: ?>
                                                                        <span class="text-light">-</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Baris 3: Keterangan (Full Width) -->
                                                    <div class="col-12">
                                                        <div class="info-item">
                                                            <div class="info-icon">
                                                                <i class="bi bi-chat-left-text"></i>
                                                            </div>
                                                            <div class="info-content">
                                                                <div class="info-label">Keterangan</div>
                                                                <div class="info-value">
                                                                    <?php if (!empty($row['keterangan'])): ?>
                                                                        <?= esc($row['keterangan']) ?>
                                                                    <?php else: ?>
                                                                        <span class="text-muted">-</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Baris 4: File Nota (jika ada) -->
                                                    <?php if (!empty($row['file_nota'])): ?>
                                                        <div class="col-12">
                                                            <div class="info-item">
                                                                <div class="info-icon">
                                                                    <i class="bi bi-paperclip"></i>
                                                                </div>
                                                                <div class="info-content">
                                                                    <div class="info-label">File Nota</div>
                                                                    <div class="info-value">
                                                                        <a href="<?= base_url('uploads/nota/' . $row['file_nota']) ?>"
                                                                            target="_blank"
                                                                            class="btn btn-sm btn-primary stylish-btn">
                                                                            <i class="bi bi-download me-1"></i> Unduh Nota
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!-- File Nota Preview (jika ada) -->
                                            <?php if (!empty($row['file_nota'])): ?>
                                                <div class="file-section">
                                                    <h6 class="section-title mb-3">
                                                        <i class="bi bi-file-earmark-text me-2"></i>Preview Nota
                                                    </h6>
                                                    <div class="file-preview-card">
                                                        <div class="preview-header">
                                                            <div class="file-info">
                                                                <div class="file-icon">
                                                                    <?php
                                                                    $fileExtension = pathinfo($row['file_nota'], PATHINFO_EXTENSION);
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
                                                                    <div class="file-name fw-semibold"><?= $row['file_nota'] ?></div>
                                                                    <div class="file-type text-muted small"><?= $fileType ?> • <?= strtoupper($fileExtension) ?></div>
                                                                </div>
                                                            </div>
                                                            <a href="<?= base_url('uploads/nota/' . $row['file_nota']) ?>"
                                                                target="_blank"
                                                                class="btn btn-primary btn-sm stylish-btn">
                                                                <i class="bi bi-download me-1"></i> Unduh
                                                            </a>
                                                        </div>
                                                        <div class="preview-content mt-3">
                                                            <?php if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                                <!-- Preview Gambar -->
                                                                <div class="image-preview text-center">
                                                                    <img src="<?= base_url('uploads/nota/' . $row['file_nota']) ?>"
                                                                        alt="Nota Pengeluaran"
                                                                        class="img-fluid rounded shadow-sm"
                                                                        style="max-height: 400px; object-fit: contain;"
                                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div class="no-preview text-center py-4" style="display: none;">
                                                                        <i class="bi bi-file-image display-4 text-muted mb-3"></i>
                                                                        <p class="text-muted">Gambar tidak dapat dimuat</p>
                                                                        <a href="<?= base_url('uploads/nota/' . $row['file_nota']) ?>"
                                                                            target="_blank"
                                                                            class="btn btn-outline-primary btn-sm">
                                                                            Lihat File
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php elseif (strtolower($fileExtension) === 'pdf'): ?>
                                                                <!-- Preview PDF (Embed) -->
                                                                <div class="pdf-preview position-relative">
                                                                    <iframe src="<?= base_url('uploads/nota/' . $row['file_nota']) ?>#view=fitH"
                                                                        width="100%"
                                                                        height="400"
                                                                        style="border: none; border-radius: 8px;"
                                                                        class="shadow-sm">
                                                                        Browser Anda tidak mendukung preview PDF.
                                                                    </iframe>
                                                                    <div class="position-absolute top-50 start-50 translate-middle opacity-0 hover-opacity-100 transition-opacity">
                                                                        <a href="<?= base_url('uploads/nota/' . $row['file_nota']) ?>"
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
                                                                    <a href="<?= base_url('uploads/nota/' . $row['file_nota']) ?>"
                                                                        target="_blank"
                                                                        class="btn btn-primary">
                                                                        <i class="bi bi-download me-1"></i> Unduh File
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer stylish-modal-footer">
                                            <button type="button" class="btn btn-secondary stylish-reset-btn" data-bs-dismiss="modal">
                                                <i class="bi bi-x-lg me-1"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-cash-stack display-1 text-light"></i>
                                    <h5 class="mt-3">Belum ada data kas keluar</h5>
                                    <p class="text-light">Data kas keluar akan muncul di sini setelah ditambahkan</p>
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

<!-- Tambahkan CSS untuk modal detail -->
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
        color: #fff;
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

    .btn-add-user {
        padding: 10px 17px;
        font-size: 0.9rem;
        border-radius: 10px;
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

    .stylish-filter-btn:hover {
        background: #4361ee;
        color: #fff;
        border-color: #4361ee;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(67, 97, 238, 0.25);
    }

    /* CSS untuk modal detail */
    .section-title {
        color: #66c0f4;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

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
</style>

<!-- Script Pagination + Search + Filter -->
<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("kasKeluarTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const searchInput = document.getElementById("searchInput");
    const paginationContainer = document.getElementById("paginationContainer");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(table.getElementsByTagName("tr"));
    }

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        return getRows().filter(row => {
            const user = row.cells[1]?.textContent.toLowerCase() || "";
            const nominal = row.cells[2]?.textContent.toLowerCase() || "";
            const ket = row.cells[3]?.textContent.toLowerCase() || "";
            const status = row.cells[5]?.textContent.toLowerCase() || "";
            return user.includes(search) || nominal.includes(search) || ket.includes(search) || status.includes(search);
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} data kas keluar | Halaman ${currentPage} dari ${totalPages}` :
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

    // Filter functionality
    document.getElementById('applyFilter').addEventListener('click', function() {
        const month = document.getElementById('filterMonth').value;
        const year = document.getElementById('filterYear').value;

        let url = '<?= site_url('admin/kas_keluar') ?>';
        const params = [];
        if (month) params.push('month=' + month);
        if (year) params.push('year=' + year);
        if (params.length) url += '?' + params.join('&');

        window.location.href = url;
    });

    document.getElementById('resetFilter').addEventListener('click', function() {
        window.location.href = '<?= site_url('admin/kas_keluar') ?>';
    });

    // Quick filter buttons
    document.querySelectorAll('.quick-filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const month = this.getAttribute('data-month');
            const year = this.getAttribute('data-year');

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
        const month = urlParams.get('month');
        const year = urlParams.get('year');

        // Set filter values from URL
        if (month) document.getElementById('filterMonth').value = month;
        if (year) document.getElementById('filterYear').value = year;

        // Set active class on quick filter buttons
        document.querySelectorAll('.quick-filter-btn').forEach(button => {
            if (button.getAttribute('data-month') === month &&
                button.getAttribute('data-year') === year) {
                button.classList.add('active');
            }
        });

        // Initialize table display
        displayTable();
    });
</script>

<?= $this->endSection() ?>