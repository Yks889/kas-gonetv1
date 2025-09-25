<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h3 mb-0 text-white">
            <i class="bi bi-cash-stack me-2"></i> Data Kas Keluar
        </h1>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!-- Table Controls -->
    <div class="row mb-3 g-2">
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

        <div class="col-md-9">
            <div class="modern-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari user, keterangan, atau status...">
            </div>
        </div>
    </div>

    <!-- Table Kas Keluar -->
    <div class="dashboard-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="kasKeluarTable">
                <thead>
                    <tr class="text-steam-blue text-uppercase small text-center">
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">User</th>
                        <th style="width: 15%;">Nominal</th>
                        <th>Keterangan</th>
                        <th style="width: 15%;">Deadline</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kas_keluar)): ?>
                        <?php $no = 1;
                        foreach ($kas_keluar as $row): ?>
                            <tr class="text-center">
                                <td><?= $no++ ?></td>
                                <td><?= esc($row['username'] ?? '-') ?></td>
                                <td class="fw-bold text-danger">
                                    Rp <?= isset($row['nominal']) ? number_format($row['nominal'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-center"><?= esc($row['keterangan'] ?? '-') ?></td>
                                <td><?= !empty($row['deadline']) ? date('d/m/Y', strtotime($row['deadline'])) : '-' ?></td>
                                <td data-status="<?= strtolower($row['status'] ?? '') ?>">
                                    <?php
                                    $status = strtolower($row['status'] ?? '');
                                    $badgeClass = match ($status) {
                                        'pending'  => 'secondary',
                                        'diterima' => 'success',
                                        'ditolak'  => 'danger',
                                        'selesai'  => 'warning text-light',
                                        default    => 'secondary'
                                    };
                                    ?>
                                    <span class="badge rounded-pill bg-<?= $badgeClass ?>">
                                        <?= ucfirst($row['status'] ?? '-') ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/kas_keluar/edit/' . $row['pengajuan_id']) ?>"
                                        class="btn btn-sm btn-outline-light stylish-btn" title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= site_url('admin/kas_keluar/delete/' . $row['pengajuan_id']) ?>"
                                        class="btn btn-sm btn-outline-danger stylish-btn" title="Hapus Data"
                                        onclick="return confirm('Yakin mau hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3">
                                <em>Tidak ada data kas keluar</em>
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

<!-- Styling sama dengan Kas Masuk -->
<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        overflow: hidden;
    }

    .table thead {
        background: rgba(67, 97, 238, 0.15);
    }

    .table tbody tr:hover {
        background: rgba(67, 97, 238, 0.08) !important;
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .btn-gradient-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 4px 14px;
        transition: 0.3s;
    }

    .stylish-btn:hover {
        background: #4361ee;
        border-color: #4361ee;
        color: #fff;
        box-shadow: 0 0 8px rgba(67, 97, 238, 0.8);
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

    .text-danger {
        color: #ef476f !important;
    }
</style>

<!-- Script Pagination + Search -->
<script>
    const rowsPerPageSelect = document.getElementById("rowsPerPage");
    const table = document.getElementById("kasKeluarTable").getElementsByTagName("tbody")[0];
    const paginationInfo = document.getElementById("paginationInfo");
    const prevBtn = document.getElementById("prevPage");
    const nextBtn = document.getElementById("nextPage");
    const searchInput = document.getElementById("searchInput");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);

    function getRows() {
        return Array.from(table.getElementsByTagName("tr")).filter(row => row.style.display !== "none" || row.cells[0].textContent.trim() !== '');
    }

    function filterRows() {
        const search = searchInput.value.toLowerCase();
        return getRows().filter(row => {
            const user = row.cells[1]?.textContent.toLowerCase() || "";
            const nominal = row.cells[2]?.textContent.toLowerCase() || "";
            const ket = row.cells[3]?.textContent.toLowerCase() || "";
            const status = row.cells[5]?.textContent.toLowerCase() || "";
            return user.includes(search) || ket.includes(search) || nominal.includes(search) || status.includes(search);
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} data kas keluar | Halaman ${currentPage} dari ${totalPages}` :
            "Tidak ada data ditemukan";

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    }

    rowsPerPageSelect.addEventListener("change", function() {
        rowsPerPage = parseInt(this.value);
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

    searchInput.addEventListener("keyup", function() {
        currentPage = 1;
        displayTable();
    });

    displayTable();
</script>

<?= $this->endSection() ?>