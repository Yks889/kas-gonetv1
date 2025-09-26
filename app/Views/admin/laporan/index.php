<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-activity me-2"></i> Aktivitas User
        </h1>
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

        <!-- Filter Role -->
        <div class="col-md-3">
            <select id="roleFilter" class="form-select form-select-sm modern-select">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        <!-- Search -->
        <div class="col-md-6">
            <div class="modern-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari berdasarkan username atau aktivitas...">
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
                                <td class="text-light">
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
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
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
</style>

<!-- Script Pagination + Filter + Search -->
<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("activityTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const roleFilter = document.getElementById("roleFilter");
    const searchInput = document.getElementById("searchInput");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(table.getElementsByTagName("tr"));
    }

    function filterRows() {
        const role = roleFilter.value.toLowerCase();
        const search = searchInput.value.toLowerCase();
        return getRows().filter(row => {
            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const roleValue = row.cells[2]?.getAttribute("data-role") || "";
            const activity = row.cells[3]?.textContent.toLowerCase() || "";
            const matchRole = !role || roleValue === role;
            const matchSearch = username.includes(search) || activity.includes(search);
            return matchRole && matchSearch;
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
    }

    rowsPerPageSelect.addEventListener("change", () => {
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        displayTable();
    });

    roleFilter.addEventListener("change", () => {
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

    document.addEventListener('DOMContentLoaded', displayTable);
</script>

<?= $this->endSection() ?>