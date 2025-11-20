<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white animate-fade-in">
            <i class="bi bi-people-fill me-2"></i> Manajemen User
        </h1>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-gradient-primary shadow-sm btn-add-user mb-2 animate-slide-in-right">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show stylish-alert animate-bounce-in" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Table Controls -->
    <div class="row mb-3 g-2 animate-fade-in-up">
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
                    placeholder="Cari username...">
            </div>
            <button class="btn btn-outline-light stylish-filter-btn" type="button" data-bs-toggle="modal"
                data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill me-1"></i> Filter
            </button>
        </div>
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
                            <h5 class="modal-title mb-0">Filter User</h5>
                            <p class="modal-subtitle mb-0">Saring data berdasarkan periode</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body stylish-modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="filterMonth" class="form-label stylish-label">
                                <i class="bi bi-calendar-month me-2"></i> Bulan
                            </label>
                            <div class="select-wrapper">
                                <select id="filterMonth" class="form-select stylish-select">
                                    <option value="">Semua Bulan</option>
                                    <?php for ($m = 1; $m <= 12; $m++): ?>
                                        <option value="<?= $m ?>" <?= (isset($_GET['month']) && $_GET['month'] == $m) ? 'selected' : '' ?>>
                                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <i class="bi bi-chevron-down select-arrow"></i>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="filterYear" class="form-label stylish-label">
                                <i class="bi bi-calendar me-2"></i> Tahun
                            </label>
                            <div class="select-wrapper">
                                <select id="filterYear" class="form-select stylish-select">
                                    <option value="">Semua Tahun</option>
                                    <?php $currentYear = date('Y'); ?>
                                    <?php for ($y = $currentYear; $y >= ($currentYear - 5); $y--): ?>
                                        <option value="<?= $y ?>" <?= (isset($_GET['year']) && $_GET['year'] == $y) ? 'selected' : '' ?>><?= $y ?></option>
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

    <!-- Bulk Actions -->
    <div id="bulkActions" class="row mb-3 animate-fade-in-up d-none">
        <div class="col-12">
            <div class="dashboard-card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="text-white me-3" id="selectedCount">0 user terpilih</span>

                        <!-- Bulk Action Buttons -->
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-outline-success btn-sm stylish-btn"
                                onclick="bulkActivateUsers()" id="bulkActivateBtn" disabled>
                                <i class="bi bi-check-lg me-1"></i> Aktifkan
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm stylish-btn"
                                onclick="bulkDeleteUsers()" id="bulkDeleteBtn" disabled>
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-light btn-sm stylish-btn"
                        onclick="clearSelection()">
                        <i class="bi bi-x-lg me-1"></i> Batalkan Pilihan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="dashboard-card p-0 overflow-hidden animate-scale-in">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="userTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">
                            <input type="checkbox" id="selectAll" class="form-check-input stylish-checkbox">
                        </th>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;" class="text-start">Username</th>
                        <th style="width: 15%;">Role</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 20%;">Tanggal Dibuat</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1;
                        foreach ($users as $user): ?>
                            <tr class="text-center animate-row-in" style="animation-delay: <?= $no * 0.05 ?>s;">
                                <td>
                                    <input type="checkbox" class="form-check-input user-checkbox stylish-checkbox"
                                        value="<?= $user['id'] ?>">
                                </td>
                                <td><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium text-white"><?= esc($user['username']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span class="badge bg-gradient-danger px-3 py-2">
                                            <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-gradient-primary px-3 py-2">
                                            <i class="bi bi-person-fill me-1"></i> User
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['is_active'] == 1): ?>
                                        <span class="badge bg-gradient-success px-3 py-2">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-gradient-warning text-light px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i> Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-light">
                                    <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <?php if ($user['is_active'] == 0): ?>
                                            <a href="<?= base_url('admin/users/activate/' . $user['id']) ?>"
                                                class="btn btn-sm btn-outline-success stylish-btn me-1"
                                                title="Konfirmasi User">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>"
                                            class="btn btn-sm btn-outline-light stylish-btn me-1"
                                            title="Edit User">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $user['id'] ?>, '<?= esc($user['username']) ?>')"
                                            class="btn btn-sm btn-outline-danger stylish-btn"
                                            title="Hapus User">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr class="animate-fade-in">
                            <td colspan="7" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-people display-1 text-light"></i>
                                    <h5 class="mt-3 text-light">Belum ada data user</h5>
                                    <p class="text-muted">Klik tombol "Tambah User" untuk menambahkan user baru</p>
                                    <a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary mt-2">
                                        <i class="bi bi-person-plus-fill me-1"></i> Tambah User Pertama
                                    </a>
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
        <button id="prevPage" class="btn btn-sm btn-outline-light stylish-btn animate-fade-in-left" disabled>
            <i class="bi bi-chevron-left"></i> Prev
        </button>

        <div id="paginationInfo" class="text-white small text-center flex-grow-1 animate-fade-in"></div>

        <button id="nextPage" class="btn btn-sm btn-outline-light stylish-btn animate-fade-in-right">
            Next <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>


<style>
    /* Styling untuk Checkbox */
    .stylish-checkbox {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.05);
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .stylish-checkbox:checked {
        background: #4361ee;
        border-color: #4361ee;
    }

    .stylish-checkbox:checked::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 12px;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .stylish-checkbox:hover {
        border-color: #4361ee;
        transform: scale(1.1);
    }

    /* Animasi untuk bulk actions */
    #bulkActions {
        animation: slideInDown 0.4s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hover effect untuk row dengan checkbox */
    .table tbody tr:hover .stylish-checkbox {
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* ANIMASI BARU */
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .animate-slide-in-right {
        animation: slideInRight 0.8s ease-out 0.3s both;
    }

    .animate-scale-in {
        animation: scaleIn 0.6s ease-out 0.4s both;
    }

    .animate-bounce-in {
        animation: bounceIn 0.8s ease-out;
    }

    .animate-row-in {
        animation: slideInUp 0.5s ease-out both;
        opacity: 0;
    }

    .animate-fade-in-left {
        animation: fadeInLeft 0.6s ease-out 0.5s both;
    }

    .animate-fade-in-right {
        animation: fadeInRight 0.6s ease-out 0.5s both;
    }

    /* Keyframes untuk animasi */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }

        50% {
            opacity: 1;
            transform: scale(1.05);
        }

        70% {
            transform: scale(0.9);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Efek hover yang lebih smooth */
    .table tbody tr {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table tbody tr:hover {
        background: rgba(67, 97, 238, 0.08) !important;
        transform: translateX(8px) scale(1.01);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.2);
    }

    /* Animasi untuk tombol */
    .stylish-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .stylish-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .stylish-btn:hover::before {
        left: 100%;
    }

    .stylish-btn:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
    }

    /* Animasi untuk badge */
    .badge {
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    /* Animasi untuk user avatar */
    .user-avatar {
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
    }

    /* Animasi untuk alert */
    .alert {
        animation: slideInDown 0.6s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* STYLING EXISTING (tetap dipertahankan) */
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        overflow: hidden;
    }

    .table thead {
        background: rgba(67, 97, 238, 0.15);
        border-bottom: 2px solid rgba(67, 97, 238, 0.3);
    }

    .badge.bg-gradient-danger {
        background: linear-gradient(45deg, #ef233c, #d90429);
        font-weight: 500;
    }

    .badge.bg-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        font-weight: 500;
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
        z-index: 2;
    }

    .modern-search input {
        padding-left: 38px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 12px;
        transition: all 0.3s ease;
        width: 100%;
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

    .user-avatar {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
    }

    .alert {
        border-radius: 10px;
        border: none;
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border-left: 4px solid #28a745;
    }

    .text-steam-blue {
        color: #66c0f4;
    }

    #paginationInfo {
        font-weight: 500;
    }

    .table tbody tr td[colspan] {
        background: rgba(26, 26, 26, 0.5);
    }

    .stylish-alert {
        border-radius: 12px;
        font-weight: 500;
        border: none;
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border-left: 4px solid #28a745;
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

    /* === SweetAlert2 Stylish Modal === */
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
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border-radius: 12px;
        margin-right: 1rem;
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

    .swal2-popup.stylish-modal .swal2-html-container {
        margin: 0;
        padding: 1.5rem;
        color: #e0e0e0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .swal2-popup.stylish-modal .info-highlight {
        background: rgba(255, 107, 107, 0.1);
        border: 1px solid rgba(255, 107, 107, 0.3);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin: 1rem 0;
        display: flex;
        align-items: center;
    }

    .swal2-popup.stylish-modal .info-highlight i {
        color: #ff6b6b;
        margin-right: 0.5rem;
        font-size: 1.1rem;
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

    .swal2-popup.stylish-modal .swal2-actions {
        margin: 0;
        padding: 1rem 1.5rem 1.5rem;
        gap: 0.75rem;
    }

    .swal2-popup.stylish-modal .swal2-confirm {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border: none;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .swal2-popup.stylish-modal .swal2-confirm:hover {
        background: linear-gradient(135deg, #ff5252, #e53935);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
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

    .swal2-popup.stylish-modal .modal-icon {
        animation: pulseWarning 2s infinite;
    }

    @keyframes pulseWarning {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }
</style>


<!-- JavaScript -->
<script>
    // Inisialisasi animasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Trigger reflow untuk memastikan animasi berjalan
        document.querySelectorAll('.animate-row-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.05}s`;
        });
    });

    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const searchInput = document.getElementById("searchInput");
    const userTable = document.getElementById("userTable").getElementsByTagName("tbody")[0];
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const paginationInfo = document.getElementById("paginationInfo");
    const paginationContainer = document.getElementById("paginationContainer");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(userTable.getElementsByTagName("tr"));
    }

    function filterRows() {
        const searchValue = searchInput.value.toLowerCase();
        return getRows().filter(row => {
            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const role = row.cells[2]?.textContent.toLowerCase() || "";
            return username.includes(searchValue) || role.includes(searchValue);
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} user | Halaman ${currentPage} dari ${totalPages}` :
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
        const totalRows = filterRows().length;
        const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));
        if (currentPage < totalPages) {
            currentPage++;
            displayTable();
        }
    });

    // Filter functionality
    document.getElementById('applyFilter').addEventListener('click', function() {
        const month = document.getElementById('filterMonth').value;
        const year = document.getElementById('filterYear').value;

        let url = '<?= base_url('admin/users') ?>';
        const params = [];
        if (month) params.push('month=' + month);
        if (year) params.push('year=' + year);
        if (params.length) url += '?' + params.join('&');

        window.location.href = url;
    });

    document.getElementById('resetFilter').addEventListener('click', function() {
        window.location.href = '<?= base_url('admin/users') ?>';
    });

    // Quick filter buttons
    document.querySelectorAll('.quick-filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const month = this.getAttribute('data-month');
            const year = this.getAttribute('data-year');

            document.getElementById('filterMonth').value = month;
            document.getElementById('filterYear').value = year;

            document.querySelectorAll('.quick-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            this.classList.add('active');
        });
    });

    // Set active class on current filter
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const month = urlParams.get('month');
        const year = urlParams.get('year');

        if (month || year) {
            document.querySelectorAll('.quick-filter-btn').forEach(button => {
                if (button.getAttribute('data-month') === month &&
                    button.getAttribute('data-year') === year) {
                    button.classList.add('active');
                }
            });
        } else {
            document.querySelector('.quick-filter-btn[data-month=""][data-year=""]').classList.add('active');
        }

        displayTable();
    });

    function confirmDelete(id, username) {
        Swal.fire({
            html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon me-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <div class="swal2-title">Hapus User</div>
                            <div class="modal-subtitle">Konfirmasi penghapusan permanen</div>
                        </div>
                    </div>

                    <div class="swal2-html-container mt-3">
                        <p>Apakah Anda yakin ingin menghapus user berikut:</p>
                        <div class="info-highlight">
                            <i class="bi bi-person-fill"></i>
                            <span class="fw-bold">${username}</span>
                        </div>
                        <div class="warning-text">
                            <i class="bi bi-exclamation-circle"></i>
                            <span>User akan dihapus secara permanen dan tidak dapat dikembalikan!</span>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Hapus',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm',
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
                    title: 'Menghapus...',
                    text: 'User sedang dihapus',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                window.location.href = "<?= base_url('admin/users/delete/') ?>" + id;
            }
        });
    }
    // Bulk Selection Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const bulkActivateBtn = document.getElementById('bulkActivateBtn');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

        // Select All functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBulkActions();
        });

        // Update bulk actions when checkboxes change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('user-checkbox')) {
                updateBulkActions();
            }
        });

        function updateBulkActions() {
            const selectedUsers = getSelectedUsers();
            const count = selectedUsers.length;

            if (count > 0) {
                bulkActions.classList.remove('d-none');
                selectedCount.textContent = `${count} user terpilih`;

                let hasPending = false;
                let hasActive = false;

                selectedUsers.forEach(userId => {
                    const checkbox = document.querySelector(`.user-checkbox[value="${userId}"]`);
                    const row = checkbox.closest('tr');
                    const statusText = row.cells[4].innerText.trim().toLowerCase();

                    if (statusText.includes('pending') || statusText.includes('menunggu')) {
                        hasPending = true;
                    }
                    if (statusText.includes('active') || statusText.includes('aktif')) {
                        hasActive = true;
                    }
                });

                // aturan baru:
                // Jika ADA user aktif → bulk activate disabled
                // Jika semua pending → bulk activate enabled
                if (hasActive) {
                    bulkActivateBtn.disabled = true;
                } else {
                    bulkActivateBtn.disabled = !hasPending;
                }

                bulkDeleteBtn.disabled = false;

                // Update select all state
                const totalCheckboxes = document.querySelectorAll('.user-checkbox').length;
                const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked').length;
                selectAllCheckbox.checked = selectedCheckboxes === totalCheckboxes;
                selectAllCheckbox.indeterminate = selectedCheckboxes > 0 && selectedCheckboxes < totalCheckboxes;

            } else {
                bulkActions.classList.add('d-none');
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
        }

        // Clear selection
        window.clearSelection = function() {
            const userCheckboxes = document.querySelectorAll('.user-checkbox');
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
            updateBulkActions();
        };
    });

    // Bulk Actions Functions
    function bulkActivateUsers() {
        const selectedUsers = getSelectedUsers();
        if (selectedUsers.length === 0) {
            Swal.fire('Peringatan', 'Tidak ada user yang dipilih', 'warning');
            return;
        }

        Swal.fire({
            html: `
            <div class="swal2-custom">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3" style="background: rgba(40, 167, 69, 0.2);">
                        <i class="bi bi-check-circle-fill" style="color: #28a745;"></i>
                    </div>
                    <div>
                        <div class="swal2-title">Aktifkan User</div>
                        <div class="modal-subtitle">Konfirmasi aktivasi multiple user</div>
                    </div>
                </div>

                <div class="swal2-html-container mt-3">
                    <p>Apakah Anda yakin ingin mengaktifkan <strong>${selectedUsers.length} user</strong>?</p>
                    <div class="info-highlight" style="background: rgba(40, 167, 69, 0.1); border-color: rgba(40, 167, 69, 0.3);">
                        <i class="bi bi-people-fill" style="color: #28a745;"></i>
                        <span>${selectedUsers.length} user pending akan diaktifkan</span>
                    </div>
                </div>
            </div>
        `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Aktifkan',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Mengaktifkan...',
                    text: `${selectedUsers.length} user sedang diaktifkan`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                // Create form data for POST request
                const formData = new FormData();
                formData.append('user_ids', JSON.stringify(selectedUsers));

                // Send batch activation request
                fetch('<?= base_url('admin/users/bulk-activate') ?>', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `${selectedUsers.length} user berhasil diaktifkan`,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan saat mengaktifkan user: ' + error.message, 'error');
                    });
            }
        });
    }

    function bulkDeleteUsers() {
        const selectedUsers = getSelectedUsers();
        if (selectedUsers.length === 0) {
            Swal.fire('Peringatan', 'Tidak ada user yang dipilih', 'warning');
            return;
        }

        Swal.fire({
            html: `
            <div class="swal2-custom">
                <div class="d-flex align-items-center">
                    <div class="modal-icon me-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <div class="swal2-title">Hapus User</div>
                        <div class="modal-subtitle">Konfirmasi penghapusan multiple user</div>
                    </div>
                </div>

                <div class="swal2-html-container mt-3">
                    <p>Apakah Anda yakin ingin menghapus <strong>${selectedUsers.length} user</strong> secara permanen?</p>
                    <div class="info-highlight">
                        <i class="bi bi-people-fill"></i>
                        <span>${selectedUsers.length} user akan dihapus permanen</span>
                    </div>
                    <div class="warning-text">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>Data yang dihapus tidak dapat dikembalikan!</span>
                    </div>
                </div>
            </div>
        `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Hapus',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: `${selectedUsers.length} user sedang dihapus`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                // Create form data for POST request
                const formData = new FormData();
                formData.append('user_ids', JSON.stringify(selectedUsers));

                // Send batch delete request
                fetch('<?= base_url('admin/users/bulk-delete') ?>', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `${selectedUsers.length} user berhasil dihapus`,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus user: ' + error.message, 'error');
                    });
            }
        });
    }

    function getSelectedUsers() {
        const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        return Array.from(selectedCheckboxes).map(cb => cb.value);
    }
</script>

<?= $this->endSection() ?>