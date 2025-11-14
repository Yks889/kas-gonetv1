<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-cash-coin me-2"></i> Data Kas Masuk
        </h1>
        <a href="<?= site_url('admin/kas_masuk/create') ?>"
            class="btn btn-gradient-primary shadow-sm btn-add-user mb-2">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kas Masuk
        </a>
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
        <!-- Total Kas Masuk -->
        <div class="col-md-4 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-arrow-down-circle text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Total Kas Masuk</h5>
                        <h3 class="card-value text-success mb-0">
                            Rp <?= isset($totalKas) ? number_format($totalKas, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Total semua pemasukan kas
                    </small>
                </div>
            </div>
        </div>
 
        <!-- Total Data Pengajuan -->
        <div class="col-md-4 mb-3">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-file-earmark-text text-info"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Total Data Pengajuan</h5>
                        <h3 class="card-value text-info mb-0">
                            <?= isset($total_pengajuan) ? number_format($total_pengajuan, 0, ',', '.') : '0' ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        Total seluruh data pengajuan
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
                    placeholder="Cari keterangan kas masuk...">
            </div>
            <button class="btn btn-outline-light stylish-filter-btn" type="button" data-bs-toggle="modal"
                data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill me-1"></i> Filter
            </button>
        </div>

        <!-- Modal Filter - Diperbarui -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content stylish-modal">
                    <div class="modal-header stylish-modal-header">
                        <div class="d-flex align-items-center">
                            <div class="modal-icon me-3">
                                <i class="bi bi-funnel-fill"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0">Filter Kas Masuk</h5>
                                <p class="modal-subtitle mb-0">Saring data berdasarkan periode tertentu</p>
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
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month=""
                                    data-year="">Semua</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn"
                                    data-month="<?= date('n') ?>" data-year="<?= date('Y') ?>">Bulan Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month=""
                                    data-year="<?= date('Y') ?>">Tahun Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month=""
                                    data-year="<?= date('Y') - 1 ?>">Tahun Lalu</button>
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

    <!-- Tabel Kas Masuk -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="kasTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Tanggal</th>
                        <th style="width: 20%;">Nominal</th>
                        <th>Keterangan</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kas_masuk)): ?>
                        <?php $no = 1;
                        foreach ($kas_masuk as $kas): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($kas['created_at'])) ?></td>
                                <td class="fw-bold text-success">Rp <?= number_format($kas['nominal'], 0, ',', '.') ?></td>
                                <td class="text-light"><?= esc($kas['keterangan']) ?></td>
                                <td>
                                    <a href="<?= site_url('admin/kas_masuk/edit/' . $kas['id']) ?>"
                                        class="btn btn-sm btn-outline-light stylish-btn" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        onclick="confirmDelete(<?= $kas['id'] ?>, '<?= esc($kas['keterangan']) ?>', 'Rp <?= number_format($kas['nominal'], 0, ',', '.') ?>')"
                                        class="btn btn-sm btn-outline-danger stylish-btn" title="Hapus Data">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-cash-stack display-1 text-light"></i>
                                    <h5 class="mt-3">Belum ada data kas masuk</h5>
                                    <p class="text-light">Data kas masuk akan muncul di sini setelah ditambahkan</p>
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

    /* Ukuran tombol Tambah lebih kecil */
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

    /* Hide pagination when not needed */
    .pagination-hidden {
        display: none !important;
    }

    /* Styling untuk Modal Filter yang diperbarui */
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

    /* === SweetAlert2 Stylish Modal untuk Hapus Kas Masuk === */
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

    /* Body Style */
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

    .swal2-popup.stylish-modal .nominal-highlight {
        background: rgba(6, 214, 160, 0.1);
        border: 1px solid rgba(6, 214, 160, 0.3);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin: 0.5rem 0;
        display: flex;
        align-items: center;
        color: #06d6a0;
        font-weight: bold;
    }

    .swal2-popup.stylish-modal .nominal-highlight i {
        color: #06d6a0;
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

    /* Footer & Buttons */
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

    /* Animasi khusus untuk modal hapus */
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

<!-- Script Pagination + Search + Filter + Delete Confirmation -->
<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("kasTable").getElementsByTagName("tbody")[0];
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
            const ket = row.cells[3]?.textContent.toLowerCase() || "";
            const nominal = row.cells[2]?.textContent.toLowerCase() || "";
            return ket.includes(search) || nominal.includes(search);
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} data kas masuk | Halaman ${currentPage} dari ${totalPages}` :
            "Tidak ada data ditemukan";

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        // Sembunyikan seluruh pagination jika data kurang dari atau sama dengan rowsPerPage
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

        let url = '<?= site_url('admin/kas_masuk') ?>';
        const params = [];
        if (month) params.push('month=' + month);
        if (year) params.push('year=' + year);
        if (params.length) url += '?' + params.join('&');

        window.location.href = url;
    });

    document.getElementById('resetFilter').addEventListener('click', function() {
        window.location.href = '<?= site_url('admin/kas_masuk') ?>';
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

        // Initialize table display
        displayTable();
    });

    // Delete Confirmation Function
    function confirmDelete(id, keterangan, nominal) {
        Swal.fire({
            html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon me-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <div class="swal2-title">Hapus Data Kas Masuk</div>
                            <div class="modal-subtitle">Konfirmasi penghapusan permanen</div>
                        </div>
                    </div>

                    <div class="swal2-html-container mt-3">
                        <p>Apakah Anda yakin ingin menghapus data kas masuk berikut:</p>
                        <div class="info-highlight">
                            <i class="bi bi-info-circle"></i>
                            <span class="fw-bold">${keterangan}</span>
                        </div>
                        <div class="nominal-highlight">
                            <i class="bi bi-cash-coin"></i>
                            <span>${nominal}</span>
                        </div>
                        <div class="warning-text">
                            <i class="bi bi-exclamation-circle"></i>
                            <span>Data ini tidak dapat dikembalikan setelah dihapus.</span>
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
                // Tampilkan loading sebelum redirect
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Data kas masuk sedang dihapus',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                window.location.href = "<?= site_url('admin/kas_masuk/delete/') ?>" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>