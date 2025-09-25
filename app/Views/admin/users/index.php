<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-white">
                <i class="bi bi-people-fill me-2"></i> Manajemen User
            </h1>
            <p class="text-light mb-0">Kelola data pengguna sistem kas</p>
        </div>
        <div class="col-md-6 text-md-end mt-2 mt-md-0">
            <a href="<?= base_url('admin/users/create') ?>" class="btn btn-gradient-primary shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah User
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <!-- Table Controls -->
    <div class="dashboard-card p-4 mb-4">
        <div class="row g-3 align-items-center">
            <!-- Rows per page -->
            <div class="col-md-3 d-flex align-items-center">
                <label class="text-white me-2 small">Tampilkan</label>
                <select id="rowsPerPage" class="form-select form-select-sm stylish-select w-auto">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <label class="text-white ms-2 small">baris</label>
            </div>

            <!-- Search -->
            <div class="col-md-6">
                <div class="modern-search">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" class="form-control form-control-sm text-light" placeholder="Cari berdasarkan username...">
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="userTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small">
                        <th style="width: 5%;" class="text-center">No</th>
                        <th style="width: 25%;" class="text-start">Username</th>
                        <th style="width: 20%;" class="text-center">Role</th>
                        <th style="width: 30%;" class="text-center">Tanggal Dibuat</th>
                        <th style="width: 20%;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1;
                        foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person-fill text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium text-white"><?= esc($user['username']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" data-role="<?= strtolower($user['role']) ?>">
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
                                <td class="text-center text-light">
                                    <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>"
                                            class="btn btn-sm btn-outline-light stylish-btn"
                                            title="Edit User"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>"
                                            class="btn btn-sm btn-outline-danger stylish-btn"
                                            title="Hapus User"
                                            data-bs-toggle="tooltip"
                                            onclick="return confirm('Yakin hapus user <?= esc($user['username']) ?>?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-light py-5">
                                <div class="py-4">
                                    <i class="bi bi-people display-1 text-light"></i>
                                    <h5 class="mt-3 text-light">Belum ada data user</h5>
                                    <p class="text-light">Klik tombol "Tambah User" untuk menambahkan user baru</p>
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
    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
        <button id="prevPage" class="btn btn-outline-light stylish-btn" disabled>
            <i class="bi bi-chevron-left"></i> Sebelumnya
        </button>

        <div id="paginationInfo" class="text-white small text-center flex-grow-1"></div>

        <button id="nextPage" class="btn btn-outline-light stylish-btn">
            Selanjutnya <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>

<!-- Styling -->
<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
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

    .stylish-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 8px;
        transition: 0.3s;
    }

    .stylish-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 8px rgba(67, 97, 238, 0.6);
        background: rgba(255, 255, 255, 0.1);
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
        border-radius: 8px;
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
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        padding: 10px 20px;
        transition: 0.3s ease;
    }

    .btn-gradient-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .stylish-btn {
        border-radius: 8px;
        padding: 6px 12px;
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

    /* Pagination styling */
    #paginationInfo {
        font-weight: 500;
    }

    /* Empty state styling */
    .table tbody tr td[colspan] {
        background: rgba(26, 26, 26, 0.5);
    }
</style>

<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const searchInput = document.getElementById("searchInput");
    const roleFilter = document.getElementById("roleFilter");
    const userTable = document.getElementById("userTable").getElementsByTagName("tbody")[0];
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const paginationInfo = document.getElementById("paginationInfo");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(userTable.getElementsByTagName("tr"));
    }

    function filterRows() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value;

        return getRows().filter(row => {
            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const role = row.cells[2]?.getAttribute("data-role") || "";

            const matchSearch = username.includes(searchValue);
            const matchRole = selectedRole === "" || role === selectedRole;

            return matchSearch && matchRole;
        });
    }

    function displayTable() {
        const allRows = getRows();
        const filteredRows = filterRows();
        const totalRows = filteredRows.length;
        const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));

        // sembunyikan semua
        allRows.forEach(row => row.style.display = "none");

        // tampilkan sesuai halaman
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        for (let i = start; i < end && i < totalRows; i++) {
            filteredRows[i].style.display = "";
        }

        // info pagination
        paginationInfo.innerHTML = totalRows > 0 ?
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} user | Halaman ${currentPage} dari ${totalPages}` :
            "Tidak ada data ditemukan";

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalRows === 0;
    }

    // Event listeners
    rowsPerPageSelect.addEventListener("change", () => {
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        displayTable();
    });

    searchInput.addEventListener("input", () => {
        currentPage = 1;
        displayTable();
    });

    roleFilter.addEventListener("change", () => {
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

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initial display
        displayTable();
    });
</script>

<?= $this->endSection() ?>