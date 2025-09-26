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

        <!-- Search -->
        <div class="col-md-9">
            <div class="modern-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm"
                    placeholder="Cari berdasarkan user, keterangan, atau nominal...">
            </div>
        </div>
    </div>

    <!-- Tabel Pengajuan -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="pengajuanTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th>No</th>
                        <th>User</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Aksi</th>
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
                                            <a href="<?= site_url('admin/pengajuan/approve/' . $p['id']) ?>"
                                                class="btn btn-sm btn-outline-success stylish-btn me-1">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                            <a href="<?= site_url('admin/pengajuan/reject/' . $p['id']) ?>"
                                                class="btn btn-sm btn-outline-danger stylish-btn">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        <?php elseif ($p['status'] == 'diterima'): ?>
                                            <?php if (!empty($p['file_nota'])): ?>
                                                <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                    target="_blank" class="btn btn-sm btn-outline-info stylish-btn">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>"
                                                    method="post" style="display:inline;">
                                                    <button type="submit" class="btn btn-sm btn-outline-light stylish-btn">
                                                        <i class="bi bi-gear"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-light stylish-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#processModal<?= $p['id'] ?>">
                                                    <i class="bi bi-upload"></i>
                                                </button>
                                            <?php endif; ?>
                                        <?php elseif ($p['status'] == 'selesai' && $p['file_nota']): ?>
                                            <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                target="_blank" class="btn btn-sm btn-outline-info stylish-btn">
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
    }
</style>

<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("pengajuanTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const searchInput = document.getElementById("searchInput");

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
            return username.includes(search) || nominal.includes(search) || keterangan.includes(search);
        });
    }

    function displayTable() {
        const allRows = getRows();
        const filteredRows = filterRows();
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

        allRows.forEach(row => row.style.display = "none");

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        for (let i = start; i < end && i < totalRows; i++) {
            if (filteredRows[i]) filteredRows[i].style.display = "";
        }

        const showingStart = totalRows > 0 ? start + 1 : 0;
        const showingEnd = Math.min(end, totalRows);

        paginationInfo.innerHTML = totalRows > 0 ?
            `Menampilkan ${showingStart} - ${showingEnd} dari ${totalRows} pengajuan` :
            "Tidak ada data ditemukan";

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalRows === 0;
    }

    rowsPerPageSelect.addEventListener("change", function() {
        rowsPerPage = parseInt(this.value);
        currentPage = 1;
        displayTable();
    });

    searchInput.addEventListener("input", function() {
        currentPage = 1;
        displayTable();
    });

    prevBtn.addEventListener("click", function() {
        if (currentPage > 1) {
            currentPage--;
            displayTable();
        }
    });

    nextBtn.addEventListener("click", function() {
        const totalPages = Math.ceil(filterRows().length / rowsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayTable();
        }
    });

    displayTable();
</script>

<?= $this->endSection() ?>