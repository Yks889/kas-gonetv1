<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-activity me-2"></i> Aktivitas User
        </h1>
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
                    placeholder="Cari berdasarkan username atau aktivitas...">
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
                                <h5 class="modal-title mb-0">Filter Aktivitas</h5>
                                <p class="modal-subtitle mb-0">Saring data berdasarkan periode dan role</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body stylish-modal-body">
                        <div class="row g-3">
                            <!-- Filter Role -->
                            <div class="col-md-6">
                                <label for="filterRole" class="form-label stylish-label">
                                    <i class="bi bi-person-badge me-2"></i> Role User
                                </label>
                                <div class="select-wrapper">
                                    <select id="filterRole" class="form-select stylish-select">
                                        <option value="">Semua Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
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

                            <!-- Filter Rentang Tanggal -->
                            <div class="col-md-6">
                                <label for="filterDateRange" class="form-label stylish-label">
                                    <i class="bi bi-calendar-range me-2"></i> Rentang Tanggal
                                </label>
                                <input type="text" id="filterDateRange" class="form-control stylish-select"
                                    placeholder="Pilih rentang tanggal...">
                            </div>
                        </div>

                        <!-- Quick Filter Options -->
                        <div class="quick-filter-section mt-4 pt-3 border-top">
                            <h6 class="text-light mb-3">Filter Cepat</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="" data-month="" data-year="">Semua</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="" data-month="<?= date('n') ?>" data-year="<?= date('Y') ?>">Bulan Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="" data-month="" data-year="<?= date('Y') ?>">Tahun Ini</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="admin" data-month="" data-year="">Admin Saja</button>
                                <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="user" data-month="" data-year="">User Saja</button>
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

    <!-- Tabel Aktivitas -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="activityTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;" class="text-start">User</th>
                        <th style="width: 15%;">Role</th>
                        <th>Aktivitas</th>
                        <th style="width: 20%;">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($activities)): ?>
                        <?php $no = 1;
                        foreach ($activities as $act): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="fw-medium text-white"><?= esc($act['username']) ?></div>
                                    </div>
                                </td>
                                <td data-role="<?= strtolower($act['role']) ?>">
                                    <?php if ($act['role'] === 'admin'): ?>
                                        <span class="badge bg-gradient-danger px-3 py-2">
                                            <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-gradient-primary px-3 py-2">
                                            <i class="bi bi-person-fill me-1"></i> User
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-light"><?= esc($act['activity']) ?></td>
                                <td class="text-light" data-timestamp="<?= strtotime($act['created_at']) ?>">
                                    <?= !empty($act['created_at'])
                                        ? date('d M Y H:i:s', strtotime($act['created_at']))
                                        : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-activity display-1 text-light"></i>
                                    <h5 class="mt-3 text-light">Belum ada aktivitas</h5>
                                    <p class="text-light">Aktivitas user akan muncul di sini setelah ada interaksi</p>
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

<!-- Styling -->
<style>
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

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table tbody tr:hover {
        background: rgba(67, 97, 238, 0.08) !important;
        transform: translateX(2px);
    }

    .badge.bg-gradient-danger {
        background: linear-gradient(45deg, #ef233c, #d90429);
        font-weight: 500;
    }

    .badge.bg-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        font-weight: 500;
    }

    /* Select modern */
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

    /* Search modern */
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

    .user-avatar {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
    }

    .text-steam-blue {
        color: #66c0f4;
    }

    /* Pagination styling */
    #paginationInfo {
        font-weight: 500;
    }

    /* Empty state styling */
    .table tbody tr td[colspan] {
        background: rgba(26, 26, 26, 0.5);
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

    .stylish-alert {
        border-radius: 12px;
        font-weight: 500;
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border: none;
        color: #fff;
        border-radius: 10px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #3a56d4, #3046c7);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        color: #fff;
    }
</style>

<!-- Script Pagination + Filter + Search -->
<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("activityTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const searchInput = document.getElementById("searchInput");
    const paginationContainer = document.getElementById("paginationContainer");

    // Filter elements
    const filterRole = document.getElementById("filterRole");
    const filterMonth = document.getElementById("filterMonth");
    const filterYear = document.getElementById("filterYear");
    const filterDateRange = document.getElementById("filterDateRange");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(table.getElementsByTagName("tr"));
    }

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        const role = filterRole.value.toLowerCase();
        const month = filterMonth.value;
        const year = filterYear.value;

        return getRows().filter(row => {
            // Filter search
            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const activity = row.cells[3]?.textContent.toLowerCase() || "";
            const matchSearch = username.includes(search) || activity.includes(search);

            // Filter role
            const roleValue = row.cells[2]?.getAttribute("data-role") || "";
            const matchRole = !role || roleValue === role;

            // Filter date
            const timestamp = parseInt(row.cells[4]?.getAttribute("data-timestamp") || "0");
            let matchDate = true;

            if (month && year) {
                const rowDate = new Date(timestamp * 1000);
                matchDate = (rowDate.getMonth() + 1 == month) && (rowDate.getFullYear() == year);
            } else if (month) {
                const rowDate = new Date(timestamp * 1000);
                matchDate = (rowDate.getMonth() + 1 == month);
            } else if (year) {
                const rowDate = new Date(timestamp * 1000);
                matchDate = (rowDate.getFullYear() == year);
            }

            return matchSearch && matchRole && matchDate;
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} aktivitas | Halaman ${currentPage} dari ${totalPages}` :
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

    // Event Listeners
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
        displayTable();
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
        modal.hide();
    });

    document.getElementById('resetFilter').addEventListener('click', function() {
        filterRole.value = '';
        filterMonth.value = '';
        filterYear.value = '';
        filterDateRange.value = '';

        // Remove active class from all quick filter buttons
        document.querySelectorAll('.quick-filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to "Semua" button
        document.querySelector('.quick-filter-btn[data-role=""][data-month=""][data-year=""]').classList.add('active');

        displayTable();
    });

    // Quick filter buttons
    document.querySelectorAll('.quick-filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const role = this.getAttribute('data-role');
            const month = this.getAttribute('data-month');
            const year = this.getAttribute('data-year');

            filterRole.value = role;
            filterMonth.value = month;
            filterYear.value = year;

            // Remove active class from all buttons
            document.querySelectorAll('.quick-filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');
        });
    });

    // Initialize date range picker (jika menggunakan library external)
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi date range picker jika diperlukan
        // Contoh: $(filterDateRange).daterangepicker();

        // Set active class on "Semua" button by default
        document.querySelector('.quick-filter-btn[data-role=""][data-month=""][data-year=""]').classList.add('active');

        // Initialize table display
        displayTable();
    });
</script>

<?= $this->endSection() ?>