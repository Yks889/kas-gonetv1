<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-people-fill me-2"></i> Manajemen User
        </h1>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-gradient-primary shadow-sm btn-add-user mb-2">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <!-- Table Controls -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <!-- Rows per page -->
        <div class="d-flex align-items-center">
            <label class="text-white me-2">Tampilkan</label>
            <select id="rowsPerPage" class="form-select form-select-sm modern-select w-auto">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <label class="text-white ms-2">baris</label>
        </div>

        <!-- Search -->
        <div class="modern-search">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" class="form-control form-control-sm text-light" placeholder="Cari berdasarkan username...">
        </div>
    </div>

    <!-- Tabel User -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="userTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;" class="text-start">Username</th>
                        <th style="width: 20%;">Role</th>
                        <th style="width: 30%;">Tanggal Dibuat</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $no = 1;
                        foreach ($users as $user): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
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
                                <td class="text-light">
                                    <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>"
                                            class="btn btn-sm btn-outline-light stylish-btn"
                                            title="Edit User"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $user['id'] ?>, '<?= esc($user['username']) ?>')"
                                            class="btn btn-sm btn-outline-danger stylish-btn"
                                            title="Hapus User"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <!-- Modal Konfirmasi Hapus -->
                                        <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content bg-dark text-white border-0 rounded-3 shadow-lg">
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title text-danger">
                                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUsername"></strong>?</p>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-1"></i> Batal
                                                        </button>
                                                        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                                                            <i class="bi bi-trash me-1"></i> Hapus
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 10px;
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
        border-radius: 8px;
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
        border-radius: 7px;
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

    .btn-gradient-primary {
        background-color: #0d6efd;
        /* Bootstrap Primary */
        border: 1px solid #0d6efd;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        padding: 10px 20px;
        transition: 0.3s ease;
    }

    .btn-gradient-primary:hover {
        background-color: #0b5ed7;
        /* lebih gelap saat hover */
        border-color: #0a58ca;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    /* Ukuran tombol Tambah User lebih kecil */
    .btn-add-user {
        padding: 10px 17px;
        /* lebih ramping */
        font-size: 0.9rem;
        /* sedikit lebih kecil */
        border-radius: 10px;
        /* sudut lebih rapih */
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

    /* Hide pagination when not needed */
    .pagination-hidden {
        display: none !important;
    }

    /* === SweetAlert2 Stylish Modal === */
    .swal2-popup.stylish-modal {
        background: linear-gradient(135deg, rgba(40, 40, 60, 0.98), rgba(30, 30, 50, 0.98));
        border: 1px solid rgba(67, 97, 238, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        color: #fff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(15px);
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
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
        color: #fff;
    }

    .swal2-popup.stylish-modal .modal-subtitle {
        color: #aaa;
        font-size: 0.9rem;
        margin: 0.25rem 0 0;
    }

    .swal2-popup.stylish-modal .info-highlight {
        background: rgba(255, 107, 107, 0.1);
        border: 1px solid rgba(255, 107, 107, 0.3);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin: 1rem 0;
        display: flex;
        align-items: center;
        color: #fff;
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
</style>

<script>
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
            return username.includes(searchValue);
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
        const totalRows = filterRows().length;
        const totalPages = Math.max(1, Math.ceil(totalRows / rowsPerPage));
        if (currentPage < totalPages) {
            currentPage++;
            displayTable();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        displayTable();
    });

    document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll(".btn-delete-user");
        const deleteModal = new bootstrap.Modal(document.getElementById("deleteUserModal"));
        const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
        const deleteUsername = document.getElementById("deleteUsername");

        deleteButtons.forEach(btn => {
            btn.addEventListener("click", function() {
                const userId = this.dataset.id;
                const username = this.dataset.username;

                // Set tampilan username di modal
                deleteUsername.textContent = username;

                // Set link delete
                confirmDeleteBtn.href = "<?= base_url('admin/users/delete/') ?>" + userId;

                // Tampilkan modal
                deleteModal.show();
            });
        });
    });

    function confirmDelete(id, username) {
        Swal.fire({
            customClass: {
                popup: 'stylish-modal'
            },
            html: `
                <div class="d-flex align-items-center mb-3">
                    <div class="modal-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div>
                        <h5 class="swal2-title">Konfirmasi Hapus</h5>
                        <p class="modal-subtitle">Aksi ini tidak bisa dibatalkan</p>
                    </div>
                </div>
                <div class="info-highlight">
                    <i class="bi bi-person-fill"></i>
                    <span>Anda akan menghapus user <b>${username}</b></span>
                </div>
                <div class="warning-text">
                    <i class="bi bi-exclamation-circle"></i> User akan dihapus secara permanen!
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Hapus',
            cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            buttonsStyling: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('admin/users/delete/') ?>" + id;
            }
        });
    }
</script>

<?= $this->endSection() ?>