<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white animate-fade-in">
            <i class="bi bi-activity me-2"></i> Aktivitas User
        </h1>
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
                    placeholder="Cari berdasarkan username atau aktivitas...">
            </div>
            <button class="btn btn-outline-light stylish-filter-btn" type="button" data-bs-toggle="modal"
                data-bs-target="#filterModal">
                <i class="bi bi-funnel-fill me-1"></i> Filter
            </button>
        </div>
    </div>

    <!-- Modal Filter - FIXED STRUCTURE -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content stylish-modal">
                <div class="modal-header stylish-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon me-3">
                            <i class="bi bi-funnel-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="filterModalLabel">Filter Aktivitas</h5>
                            <p class="modal-subtitle mb-0">Saring data berdasarkan periode dan role</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button class="btn btn-sm btn-outline-light quick-filter-btn active" data-role="" data-month="" data-year="">Semua</button>
                            <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="" data-month="<?= date('n') ?>" data-year="<?= date('Y') ?>">Bulan Ini</button>
                            <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="" data-month="" data-year="<?= date('Y') ?>">Tahun Ini</button>
                            <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="admin" data-month="" data-year="">Admin Saja</button>
                            <button class="btn btn-sm btn-outline-light quick-filter-btn" data-role="user" data-month="" data-year="">User Saja</button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer stylish-modal-footer">
                    <button type="button" id="resetFilter" class="btn btn-outline-light stylish-reset-btn">
                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                    </button>
                    <button type="button" id="applyFilter" class="btn btn-gradient-primary stylish-apply-btn" data-bs-dismiss="modal">
                        <i class="bi bi-check-lg me-1"></i> Terapkan Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivitas -->
    <div class="dashboard-card p-0 overflow-hidden animate-scale-in">
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
                            <tr class="text-center animate-row-in" style="animation-delay: <?= $no * 0.05 ?>s;">
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
                        <tr class="animate-fade-in">
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
        <button id="prevPage" class="btn btn-sm btn-outline-light stylish-btn animate-fade-in-left" disabled>
            <i class="bi bi-chevron-left"></i> Prev
        </button>

        <div id="paginationInfo" class="text-white small text-center flex-grow-1 animate-fade-in"></div>

        <button id="nextPage" class="btn btn-sm btn-outline-light stylish-btn animate-fade-in-right">
            Next <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<!-- Styling -->
<style>
    /* ANIMASI BARU */
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.2s both;
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

    /* Styling untuk Modal Filter - FIXED */
    .stylish-modal {
        background: linear-gradient(135deg, rgba(40, 40, 60, 0.95) 0%, rgba(30, 30, 50, 0.95) 100%);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stylish-modal-header {
        background: rgba(0, 0, 0, 0.8);
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
        background: rgba(43, 43, 43, 0.95);
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
        background: rgba(30, 30, 30, 0.95);
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

    /* FIX untuk modal backdrop */
    .modal-backdrop {
        z-index: 1040;
    }

    .modal {
        z-index: 1050;
    }
</style>

<!-- Script Pagination + Filter + Search - FIXED -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi variabel
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

        // Trigger reflow untuk memastikan animasi berjalan
        document.querySelectorAll('.animate-row-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.05}s`;
        });

        function getRows() {
            return Array.from(table.getElementsByTagName("tr"));
        }

        function filterRows() {
            const search = searchInput.value.toLowerCase();
            const role = filterRole.value.toLowerCase();
            const month = filterMonth.value;
            const year = filterYear.value;

            return getRows().filter(row => {
                // Skip row jika colspan (no data row)
                if (row.cells.length <= 1) return false;

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

            // Sembunyikan semua rows
            allRows.forEach(row => row.style.display = "none");

            // Tampilkan rows untuk halaman saat ini
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            for (let i = start; i < end && i < totalRows; i++) {
                filteredRows[i].style.display = "";
            }

            // Update pagination info
            paginationInfo.innerHTML = totalRows > 0 ?
                `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} aktivitas | Halaman ${currentPage} dari ${totalPages}` :
                "Tidak ada data ditemukan";

            // Update button states
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages || totalPages === 0;

            // Sembunyikan pagination jika data sedikit
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

        // Filter functionality - FIXED
        document.getElementById('applyFilter').addEventListener('click', function() {
            displayTable();
            // Modal akan tertutup otomatis karena data-bs-dismiss="modal"
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

            currentPage = 1;
            displayTable();
        });

        // Quick filter buttons - FIXED
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

                // Apply filter dan tutup modal
                currentPage = 1;
                displayTable();
                
                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('filterModal'));
                if (modal) {
                    modal.hide();
                }
            });
        });

        // Initialize table display
        displayTable();

        // Test modal functionality
        console.log('Modal functionality loaded successfully');
    });
</script>

<?= $this->endSection() ?>