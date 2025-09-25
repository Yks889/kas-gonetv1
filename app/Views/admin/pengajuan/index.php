<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center py-3 mb-4 border-bottom border-light-subtle">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">
                <i class="bi bi-cash-coin me-2 text-primary"></i>Manajemen Pengajuan
            </h1>
            <p class="text-muted mb-0">Kelola semua pengajuan kas dari user</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" id="exportBtn">
                <i class="bi bi-download me-1"></i>Export
            </button>
            <button class="btn btn-primary" id="refreshBtn">
                <i class="bi bi-arrow-clockwise me-1"></i>Refresh
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div class="flex-grow-1"><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            <div class="flex-grow-1"><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-1">Total Pengajuan</h6>
                            <h3 class="fw-bold text-primary mb-0"><?= number_format(count($pengajuan ?? [])) ?></h3>
                        </div>
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-file-earmark-text text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-1">Pending</h6>
                            <h3 class="fw-bold text-warning mb-0"><?= number_format(count(array_filter($pengajuan ?? [], function ($p) {
                                                                        return $p['status'] === 'pending';
                                                                    }))) ?></h3>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-clock-history text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-1">Diterima</h6>
                            <h3 class="fw-bold text-success mb-0"><?= number_format(count(array_filter($pengajuan ?? [], function ($p) {
                                                                        return $p['status'] === 'diterima';
                                                                    }))) ?></h3>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-muted mb-1">Ditolak</h6>
                            <h3 class="fw-bold text-danger mb-0"><?= number_format(count(array_filter($pengajuan ?? [], function ($p) {
                                                                        return $p['status'] === 'ditolak';
                                                                    }))) ?></h3>
                        </div>
                        <div class="stat-icon bg-danger">
                            <i class="bi bi-x-circle text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Controls -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-3 d-flex align-items-center">
                    <label class="form-label mb-0 me-2 text-dark fw-medium">Tampilkan</label>
                    <select id="rowsPerPage" class="form-select form-select-sm w-auto">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <label class="form-label mb-0 ms-2 text-dark fw-medium">baris</label>
                </div>

                <div class="col-md-3">
                    <select id="statusFilter" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari berdasarkan user, keterangan, atau nominal...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pengajuan -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="pengajuanTable">
                    <thead class="table-light">
                        <tr class="text-uppercase small">
                            <th class="text-center" style="width: 60px;">No</th>
                            <th style="width: 150px;">User</th>
                            <th class="text-end" style="width: 150px;">Nominal</th>
                            <th>Keterangan</th>
                            <th class="text-center" style="width: 120px;">Tipe</th>
                            <th class="text-center" style="width: 120px;">Deadline</th>
                            <th class="text-center" style="width: 120px;">Status</th>
                            <th class="text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengajuan)): ?>
                            <?php $no = 1; ?>
                            <?php foreach ($pengajuan as $p): ?>
                                <tr>
                                    <td class="text-center fw-medium text-muted"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="bi bi-person-fill text-white"></i>
                                            </div>
                                            <span class="fw-medium"><?= esc($p['username']) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold text-success">
                                        Rp <?= number_format($p['nominal'], 0, ',', '.') ?>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 250px;" title="<?= esc($p['keterangan']) ?>">
                                            <?= esc($p['keterangan']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($p['tipe'])): ?>
                                            <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2">
                                                    <i class="bi bi-wallet2 me-1"></i>Uang Sendiri
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                                                    <i class="bi bi-building me-1"></i>Minta Admin
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($p['deadline']): ?>
                                            <span class="badge bg-light text-dark border">
                                                <?= date('d/m/Y', strtotime($p['deadline'])) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center" data-status="<?= strtolower($p['status']) ?>">
                                        <?php
                                        $statusConfig = [
                                            'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'clock'],
                                            'diterima' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'check-circle'],
                                            'ditolak' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'x-circle'],
                                            'selesai' => ['class' => 'bg-primary bg-opacity-10 text-primary', 'icon' => 'check2-all']
                                        ];
                                        $config = $statusConfig[$p['status']] ?? $statusConfig['pending'];
                                        ?>
                                        <span class="badge <?= $config['class'] ?> border border-opacity-25 px-3 py-2">
                                            <i class="bi bi-<?= $config['icon'] ?> me-1"></i><?= ucfirst($p['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <?php if ($p['status'] == 'pending'): ?>
                                                <a href="<?= site_url('admin/pengajuan/approve/' . $p['id']) ?>"
                                                    class="btn btn-sm btn-success px-3"
                                                    title="Setujui Pengajuan">
                                                    <i class="bi bi-check-lg me-1"></i>Setujui
                                                </a>
                                                <a href="<?= site_url('admin/pengajuan/reject/' . $p['id']) ?>"
                                                    class="btn btn-sm btn-danger px-3"
                                                    title="Tolak Pengajuan">
                                                    <i class="bi bi-x-lg me-1"></i>Tolak
                                                </a>
                                            <?php elseif ($p['status'] == 'diterima'): ?>
                                                <?php if (!empty($p['file_nota'])): ?>
                                                    <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-info px-3"
                                                        title="Lihat File Nota">
                                                        <i class="bi bi-eye me-1"></i>File
                                                    </a>
                                                    <form action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>"
                                                        method="post"
                                                        style="display:inline;">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary px-3"
                                                            title="Proses Pengajuan">
                                                            <i class="bi bi-gear me-1"></i>Proses
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button type="button"
                                                        class="btn btn-sm btn-primary px-3"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#processModal<?= $p['id'] ?>"
                                                        title="Upload Nota dan Proses">
                                                        <i class="bi bi-upload me-1"></i>Proses
                                                    </button>
                                                <?php endif; ?>
                                            <?php elseif ($p['status'] == 'selesai' && $p['file_nota']): ?>
                                                <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                    target="_blank"
                                                    class="btn btn-sm btn-info px-3"
                                                    title="Lihat File Nota">
                                                    <i class="bi bi-eye me-1"></i>File
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Tidak ada aksi</span>
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
                                                <form method="post" action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-medium">Upload Nota/Struk</label>
                                                            <input type="file" class="form-control" name="file_nota" accept=".jpg,.jpeg,.png,.pdf" required>
                                                            <div class="form-text">Format yang didukung: JPG, PNG, PDF (Maks. 5MB)</div>
                                                        </div>
                                                        <div class="alert alert-info">
                                                            <i class="bi bi-info-circle me-2"></i>
                                                            Pastikan file nota jelas dan dapat dibaca sebelum melanjutkan proses.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bi bi-check-lg me-1"></i>Proses Pengajuan
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
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                        <h5 class="fw-medium">Belum ada data pengajuan</h5>
                                        <p class="mb-0">Semua pengajuan yang diajukan user akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted small">
            <span id="paginationInfo">Menampilkan 0 dari 0 data</span>
        </div>
        <div class="d-flex gap-2">
            <button id="prevPage" class="btn btn-outline-primary btn-sm" disabled>
                <i class="bi bi-chevron-left"></i> Sebelumnya
            </button>
            <button id="nextPage" class="btn btn-outline-primary btn-sm">
                Selanjutnya <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Styling -->
<style>
    .stat-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }

    .table th {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
    }

    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-color: #f1f3f4;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa !important;
        transform: scale(1.002);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .badge {
        font-weight: 500;
        border-radius: 6px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .form-select,
    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        transition: all 0.2s ease;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.1);
    }

    .alert {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-radius: 12px 12px 0 0;
        border-bottom: 1px solid #dee2e6;
    }

    .text-truncate {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("pengajuanTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const statusFilter = document.getElementById("statusFilter");
    const searchInput = document.getElementById("searchInput");
    const refreshBtn = document.getElementById("refreshBtn");
    const exportBtn = document.getElementById("exportBtn");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(table.getElementsByTagName("tr"));
    }

    function filterRows() {
        const status = statusFilter.value.toLowerCase();
        const search = searchInput.value.toLowerCase();

        return getRows().filter(row => {
            if (row.cells.length < 8) return false; // Skip empty rows

            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const nominal = row.cells[2]?.textContent.toLowerCase() || "";
            const keterangan = row.cells[3]?.textContent.toLowerCase() || "";
            const statusValue = row.cells[6]?.getAttribute("data-status") || "";

            const matchStatus = !status || statusValue === status;
            const matchSearch = username.includes(search) || keterangan.includes(search) || nominal.includes(search);

            return matchStatus && matchSearch;
        });
    }

    function displayTable() {
        const allRows = getRows();
        const filteredRows = filterRows();
        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;

        // Hide all rows
        allRows.forEach(row => row.style.display = "none");

        // Show rows for current page
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        for (let i = start; i < end && i < totalRows; i++) {
            if (filteredRows[i]) {
                filteredRows[i].style.display = "";
            }
        }

        // Update pagination info
        const showingStart = totalRows > 0 ? start + 1 : 0;
        const showingEnd = Math.min(end, totalRows);

        paginationInfo.innerHTML = totalRows > 0 ?
            `Menampilkan ${showingStart} - ${showingEnd} dari ${totalRows} pengajuan` :
            "Tidak ada data ditemukan";

        // Update button states
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalRows === 0;
    }

    // Event listeners
    rowsPerPageSelect.addEventListener("change", function() {
        rowsPerPage = parseInt(this.value);
        currentPage = 1;
        displayTable();
    });

    statusFilter.addEventListener("change", function() {
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

    refreshBtn.addEventListener("click", function() {
        currentPage = 1;
        searchInput.value = "";
        statusFilter.value = "";
        rowsPerPageSelect.value = "10";
        rowsPerPage = 10;
        displayTable();

        // Add loading animation
        this.querySelector('i').classList.add('spin');
        setTimeout(() => {
            this.querySelector('i').classList.remove('spin');
        }, 500);
    });

    exportBtn.addEventListener("click", function() {
        alert('Fitur export akan segera tersedia!');
    });

    // Add spin animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .bi-arrow-clockwise.spin {
            animation: spin 0.5s linear;
        }
    `;
    document.head.appendChild(style);

    // Initialize table
    displayTable();
</script>

<?= $this->endSection() ?>