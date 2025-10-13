<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-clock-history me-2"></i> History Pengajuan
        </h1>
        <a href="<?= site_url('user/pengajuan/create') ?>" class="btn btn-gradient-primary shadow-sm btn-add-user mb-2">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pengajuan
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show stylish-alert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
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
                    placeholder="Cari keterangan pengajuan...">
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

                        <!-- Filter Status -->
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label for="filterStatus" class="form-label stylish-label">
                                    <i class="bi bi-info-circle me-2"></i> Status
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterStatus" class="form-select stylish-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="diterima">Diterima</option>
                                        <option value="ditolak">Ditolak</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                    <i class="bi bi-chevron-down select-arrow"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Filter Options -->
                        <div class="quick-filter-section mt-4 pt-3 border-top">
                            <h6 class="text-light mb-3">Filter Cepat</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month="" data-year=""
                                    data-status="">Semua</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn"
                                    data-month="<?= date('n') ?>" data-year="<?= date('Y') ?>" data-status="">Bulan
                                    Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month=""
                                    data-year="<?= date('Y') ?>" data-status="">Tahun Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-month=""
                                    data-year="<?= date('Y') - 1 ?>" data-status="">Tahun Lalu</button>
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

    <!-- Tabel History Pengajuan -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="pengajuanTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 15%;">Nominal</th>
                        <th>Keterangan</th>
                        <th style="width: 12%;">Tipe</th>
                        <th style="width: 12%;">Deadline</th>
                        <th style="width: 12%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengajuan)): ?>
                        <?php $no = 1;
                        foreach ($pengajuan as $p): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                <td class="fw-bold text-success">Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                <td class="text-light"><?= esc($p['keterangan']) ?></td>
                                <td>
                                    <?= $p['tipe'] == 'uang_sendiri'
                                        ? '<span class="badge bg-info">Uang Sendiri</span>'
                                        : '<span class="badge bg-primary">Minta Uang</span>' ?>
                                </td>
                                <td><?= $p['deadline'] ? date('d/m/Y', strtotime($p['deadline'])) : '-' ?></td>
                                <td>
                                    <span class="badge bg-<?=
                                        $p['status'] == 'diterima' ? 'success' : ($p['status'] == 'ditolak' ? 'danger' : ($p['status'] == 'selesai' ? 'warning' : 'secondary'))
                                        ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-clock-history display-1 text-light"></i>
                                    <h5 class="mt-3">Belum ada history pengajuan</h5>
                                    <p class="text-muted">Data pengajuan akan muncul di sini setelah Anda membuat pengajuan
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
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
</style>

<!-- Script Pagination + Search + Filter -->
<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("pengajuanTable").getElementsByTagName("tbody")[0];
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
            const tipe = row.cells[4]?.textContent.toLowerCase() || "";
            const status = row.cells[6]?.textContent.toLowerCase() || "";

            return ket.includes(search) || nominal.includes(search) ||
                tipe.includes(search) || status.includes(search);
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} data pengajuan | Halaman ${currentPage} dari ${totalPages}` :
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
    document.getElementById('applyFilter').addEventListener('click', function () {
        const month = document.getElementById('filterMonth').value;
        const year = document.getElementById('filterYear').value;
        const status = document.getElementById('filterStatus').value;

        let url = '<?= site_url('user/pengajuan') ?>';
        const params = [];
        if (month) params.push('month=' + month);
        if (year) params.push('year=' + year);
        if (status) params.push('status=' + status);
        if (params.length) url += '?' + params.join('&');

        window.location.href = url;
    });

    document.getElementById('resetFilter').addEventListener('click', function () {
        window.location.href = '<?= site_url('user/pengajuan') ?>';
    });

    // Quick filter buttons
    document.querySelectorAll('.quick-filter-btn').forEach(button => {
        button.addEventListener('click', function () {
            const month = this.getAttribute('data-month');
            const year = this.getAttribute('data-year');
            const status = this.getAttribute('data-status');

            document.getElementById('filterMonth').value = month;
            document.getElementById('filterYear').value = year;
            document.getElementById('filterStatus').value = status;

            // Remove active class from all buttons
            document.querySelectorAll('.quick-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');
        });
    });

    // Set active class on current filter
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const month = urlParams.get('month');
        const year = urlParams.get('year');
        const status = urlParams.get('status');

        if (month || year || status) {
            document.querySelectorAll('.quick-filter-btn').forEach(button => {
                if (button.getAttribute('data-month') === month &&
                    button.getAttribute('data-year') === year &&
                    button.getAttribute('data-status') === status) {
                    button.classList.add('active');
                }
            });

            // Set filter values
            if (month) document.getElementById('filterMonth').value = month;
            if (year) document.getElementById('filterYear').value = year;
            if (status) document.getElementById('filterStatus').value = status;
        } else {
            document.querySelector('.quick-filter-btn[data-month=""][data-year=""][data-status=""]').classList.add('active');
        }

        // Initialize table display
        displayTable();
    });
</script>

<?= $this->endSection() ?>