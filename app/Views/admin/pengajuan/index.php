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
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">User</th>
                        <th style="width: 15%;">Nominal</th>
                        <th>Keterangan</th>
                        <th style="width: 10%;">Tipe</th>
                        <th style="width: 12%;">Deadline</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Aksi</th>
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
                                                        <button onclick="confirmApprove(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>', '<?= $p['tipe'] ?>')"
                                                            class="btn btn-sm btn-outline-success stylish-btn me-1"
                                                            title="Setujui Pengajuan">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                        <button onclick="confirmReject(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>')"
                                                            class="btn btn-sm btn-outline-danger stylish-btn"
                                                            title="Tolak Pengajuan">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                <?php elseif ($p['status'] == 'diterima'): ?>
                                                        <?php if (!empty($p['file_nota'])): ?>
                                                                <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                                    target="_blank" class="btn btn-sm btn-outline-info stylish-btn me-1"
                                                                    title="Lihat Nota">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <?php if ($p['tipe'] === 'uang_sendiri'): ?>
                                                                        <button onclick="confirmProcessUangSendiri(<?= $p['id'] ?>, '<?= esc($p['username']) ?>', 'Rp <?= number_format($p['nominal'], 0, ',', '.') ?>', '<?= esc($p['keterangan']) ?>')"
                                                                            class="btn btn-sm btn-outline-light stylish-btn"
                                                                            title="Proses Pengajuan">
                                                                            <i class="bi bi-gear"></i>
                                                                        </button>
                                                                <?php else: ?>
                                                                        <form action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>"
                                                                            method="post" style="display:inline;">
                                                                            <button type="submit" class="btn btn-sm btn-outline-light stylish-btn"
                                                                                title="Proses Pengajuan">
                                                                                <i class="bi bi-gear"></i>
                                                                            </button>
                                                                        </form>
                                                                <?php endif; ?>
                                                        <?php else: ?>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-light stylish-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#processModal<?= $p['id'] ?>"
                                                                    title="Upload Nota">
                                                                    <i class="bi bi-upload"></i>
                                                                </button>
                                                        <?php endif; ?>
                                                <?php elseif ($p['status'] == 'selesai' && $p['file_nota']): ?>
                                                        <a href="<?= base_url('uploads/nota/' . $p['file_nota']) ?>"
                                                            target="_blank" class="btn btn-sm btn-outline-info stylish-btn"
                                                            title="Lihat Nota">
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

    /* === SweetAlert2 Stylish Modal untuk Konfirmasi === */
    .swal2-popup.stylish-confirm-modal {
        background: linear-gradient(135deg, rgba(40, 40, 60, 0.98) 0%, rgba(30, 30, 50, 0.98) 100%);
        border: 1px solid rgba(67, 97, 238, 0.3);
        border-radius: 16px;
        padding: 0;
        color: #fff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(15px);
        overflow: hidden;
    }

    /* Header Style untuk Approve */
    .swal2-popup.stylish-confirm-modal .approve-header {
        background: linear-gradient(135deg, rgba(6, 214, 160, 0.2) 0%, rgba(6, 214, 160, 0.1) 100%);
        border-bottom: 1px solid rgba(6, 214, 160, 0.3);
    }

    /* Header Style untuk Reject */
    .swal2-popup.stylish-confirm-modal .reject-header {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.2) 0%, rgba(255, 107, 107, 0.1) 100%);
        border-bottom: 1px solid rgba(255, 107, 107, 0.3);
    }

    /* Header Style untuk Process */
    .swal2-popup.stylish-confirm-modal .process-header {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.2) 0%, rgba(67, 97, 238, 0.1) 100%);
        border-bottom: 1px solid rgba(67, 97, 238, 0.3);
    }

    .swal2-popup.stylish-confirm-modal .swal2-header {
        margin: 0;
        padding: 1.5rem 1.5rem 1rem;
    }

    .swal2-popup.stylish-confirm-modal .modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 12px;
        margin-right: 1rem;
    }

    .swal2-popup.stylish-confirm-modal .approve-icon {
        background: linear-gradient(135deg, #06d6a0, #05c293);
    }

    .swal2-popup.stylish-confirm-modal .reject-icon {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
    }

    .swal2-popup.stylish-confirm-modal .process-icon {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
    }

    .swal2-popup.stylish-confirm-modal .modal-icon i {
        color: #fff;
        font-size: 1.5rem;
    }

    .swal2-popup.stylish-confirm-modal .swal2-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }

    .swal2-popup.stylish-confirm-modal .modal-subtitle {
        color: #aaa;
        font-size: 0.9rem;
        margin: 0.25rem 0 0 0;
    }

    /* Body Style */
    .swal2-popup.stylish-confirm-modal .swal2-html-container {
        margin: 0;
        padding: 1.5rem;
        color: #e0e0e0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .swal2-popup.stylish-confirm-modal .info-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 1rem;
        margin: 1rem 0;
    }

    .swal2-popup.stylish-confirm-modal .info-item {
        display: flex;
        justify-content: between;
        margin-bottom: 0.5rem;
    }

    .swal2-popup.stylish-confirm-modal .info-label {
        color: #aaa;
        min-width: 80px;
    }

    .swal2-popup.stylish-confirm-modal .info-value {
        color: #fff;
        font-weight: 500;
    }

    .swal2-popup.stylish-confirm-modal .nominal-highlight {
        color: #06d6a0;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .swal2-popup.stylish-confirm-modal .tipe-highlight {
        color: #4361ee;
        font-weight: bold;
    }

    .swal2-popup.stylish-confirm-modal .warning-text {
        color: #ffd166;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
    }

    .swal2-popup.stylish-confirm-modal .warning-text i {
        margin-right: 0.5rem;
    }

    .swal2-popup.stylish-confirm-modal .important-note {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: 8px;
        padding: 0.75rem;
        margin: 1rem 0;
        color: #ffd166;
    }

    .swal2-popup.stylish-confirm-modal .important-note i {
        margin-right: 0.5rem;
    }

    /* Footer & Buttons */
    .swal2-popup.stylish-confirm-modal .swal2-actions {
        margin: 0;
        padding: 1rem 1.5rem 1.5rem;
        gap: 0.75rem;
    }

    .swal2-popup.stylish-confirm-modal .swal2-confirm {
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .swal2-popup.stylish-confirm-modal .approve-confirm {
        background: linear-gradient(135deg, #06d6a0, #05c293);
        border: none;
    }

    .swal2-popup.stylish-confirm-modal .reject-confirm {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border: none;
    }

    .swal2-popup.stylish-confirm-modal .process-confirm {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border: none;
    }

    .swal2-popup.stylish-confirm-modal .swal2-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .swal2-popup.stylish-confirm-modal .approve-confirm:hover {
        box-shadow: 0 6px 15px rgba(6, 214, 160, 0.4);
    }

    .swal2-popup.stylish-confirm-modal .reject-confirm:hover {
        box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
    }

    .swal2-popup.stylish-confirm-modal .process-confirm:hover {
        box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
    }

    .swal2-popup.stylish-confirm-modal .swal2-cancel {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 10px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .swal2-popup.stylish-confirm-modal .swal2-cancel:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
</style>

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
            if (row.cells.length < 8) return false;
            const username = row.cells[1]?.textContent.toLowerCase() || "";
            const nominal = row.cells[2]?.textContent.toLowerCase() || "";
            const keterangan = row.cells[3]?.textContent.toLowerCase() || "";
            const tipe = row.cells[4]?.textContent.toLowerCase() || "";
            const status = row.cells[6]?.textContent.toLowerCase() || "";
            
            return username.includes(search) || 
                   nominal.includes(search) || 
                   keterangan.includes(search) ||
                   tipe.includes(search) ||
                   status.includes(search);
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
            `Menampilkan ${start + 1} - ${Math.min(end, totalRows)} dari ${totalRows} pengajuan | Halaman ${currentPage} dari ${totalPages}` :
            "Tidak ada data ditemukan";

        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

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

    // ===========================
    // FUNGSI POST DINAMIS
    // ===========================
    function postToProcess(id) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "<?= site_url('admin/pengajuan/process/') ?>" + id;
        document.body.appendChild(form);
        form.submit();
    }

    // Konfirmasi Approve
    function confirmApprove(id, username, nominal, keterangan, tipe) {
        let tipeInfo = tipe === 'uang_sendiri' ?
            `<div class="info-item"><span class="info-label">Tipe:</span><span class="info-value tipe-highlight">Uang Sendiri</span></div>` :
            `<div class="info-item"><span class="info-label">Tipe:</span><span class="info-value tipe-highlight">Minta Admin</span></div>`;

        Swal.fire({
            html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center approve-header">
                        <div class="modal-icon approve-icon me-3"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <div class="swal2-title">Setujui Pengajuan</div>
                            <div class="modal-subtitle">Konfirmasi persetujuan pengajuan kas</div>
                        </div>
                    </div>
                    <div class="swal2-html-container mt-3">
                        <p>Apakah Anda yakin ingin menyetujui pengajuan berikut:</p>
                        <div class="info-section">
                            <div class="info-item"><span class="info-label">User:</span><span class="info-value">${username}</span></div>
                            ${tipeInfo}
                            <div class="info-item"><span class="info-label">Nominal:</span><span class="info-value nominal-highlight">${nominal}</span></div>
                            <div class="info-item"><span class="info-label">Keterangan:</span><span class="info-value">${keterangan}</span></div>
                        </div>
                        <div class="warning-text"><i class="bi bi-info-circle"></i><span>Status pengajuan akan berubah menjadi "Diterima"</span></div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Setujui',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-confirm-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm approve-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // tampilkan loading
                Swal.fire({ title: 'Menyetujui...', text: 'Pengajuan sedang diproses', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

                // -- PERBAIKAN: untuk "approve" harus menuju route approve, bukan process --
                // GANTI: postToProcess(id);
                // MENJADI:
                window.location.href = "<?= site_url('admin/pengajuan/approve/') ?>" + id; // <-- GANTI DISINI
            }
        });
    }

    // Konfirmasi Reject
    function confirmReject(id, username, nominal, keterangan) {
        Swal.fire({
            html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center reject-header">
                        <div class="modal-icon reject-icon me-3"><i class="bi bi-x-circle-fill"></i></div>
                        <div>
                            <div class="swal2-title">Tolak Pengajuan</div>
                            <div class="modal-subtitle">Konfirmasi penolakan pengajuan kas</div>
                        </div>
                    </div>
                    <div class="swal2-html-container mt-3">
                        <p>Apakah Anda yakin ingin menolak pengajuan berikut:</p>
                        <div class="info-section">
                            <div class="info-item"><span class="info-label">User:</span><span class="info-value">${username}</span></div>
                            <div class="info-item"><span class="info-label">Nominal:</span><span class="info-value nominal-highlight">${nominal}</span></div>
                            <div class="info-item"><span class="info-label">Keterangan:</span><span class="info-value">${keterangan}</span></div>
                        </div>
                        <div class="warning-text"><i class="bi bi-exclamation-triangle"></i><span>Status pengajuan akan berubah menjadi "Ditolak" dan tidak dapat diubah</span></div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Ya, Tolak',
            cancelButtonText: '<i class="bi bi-arrow-left me-1"></i> Batal',
            customClass: {
                popup: 'stylish-confirm-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm reject-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Menolak...', text: 'Pengajuan sedang diproses', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                window.location.href = "<?= site_url('admin/pengajuan/reject/') ?>" + id; // tetap GET untuk reject
            }
        });
    }

    // Konfirmasi Process untuk Uang Sendiri
    function confirmProcessUangSendiri(id, username, nominal, keterangan) {
        Swal.fire({
            html: `
                <div class="swal2-custom">
                    <div class="d-flex align-items-center process-header">
                        <div class="modal-icon process-icon me-3"><i class="bi bi-gear-fill"></i></div>
                        <div>
                            <div class="swal2-title">Proses Pengajuan Uang Sendiri</div>
                            <div class="modal-subtitle">Konfirmasi pemotongan saldo kas</div>
                        </div>
                    </div>
                    <div class="swal2-html-container mt-3">
                        <p>Apakah Anda yakin ingin memproses pengajuan uang sendiri berikut:</p>
                        <div class="info-section">
                            <div class="info-item"><span class="info-label">User:</span><span class="info-value">${username}</span></div>
                            <div class="info-item"><span class="info-label">Tipe:</span><span class="info-value tipe-highlight">Uang Sendiri</span></div>
                            <div class="info-item"><span class="info-label">Nominal:</span><span class="info-value nominal-highlight">${nominal}</span></div>
                            <div class="info-item"><span class="info-label">Keterangan:</span><span class="info-value">${keterangan}</span></div>
                        </div>
                        <div class="important-note"><i class="bi bi-exclamation-triangle-fill"></i><strong>Penting:</strong> Aksi ini akan langsung memotong saldo kas sebesar ${nominal}</div>
                        <div class="warning-text"><i class="bi bi-info-circle"></i><span>Status pengajuan akan berubah menjadi "Selesai" dan tidak dapat diubah kembali</span></div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Proses',
            cancelButtonText: '<i class="bi bi-x-lg me-1"></i> Batal',
            customClass: {
                popup: 'stylish-confirm-modal',
                header: 'd-none',
                title: 'swal2-title',
                htmlContainer: 'swal2-html-container',
                confirmButton: 'swal2-confirm process-confirm',
                cancelButton: 'swal2-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ title: 'Memproses...', text: 'Pengajuan sedang diproses', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                postToProcess(id); // <-- pakai POST untuk memproses uang_sendiri
            }
        });
    }

    // Tampilkan tabel pertama kali
    displayTable();
</script>



<?= $this->endSection() ?>