<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4 bord">
        <div>
            <h1 class="h3 mb-2 text-white">
                <i class="bi bi-bank me-2"></i>Dashboard Admin GoNet
            </h1>
            <p class="mb-0 text-light">Dashboard Keuangan Sistem GoNet</p>
        </div>

        <!-- Filter Tanggal - DIPERBARUI dengan border color -->
        <div class="d-flex align-items-center">
            <div class="filter-card d-flex align-items-center">
                <span class="text-light me-2 small"><i class="bi bi-calendar3 me-1"></i> Periode:</span>
                <form method="get" action="<?= site_url('admin/dashboard') ?>" class="d-inline-flex">
                    <select name="bulan"
                        class="form-select form-select-sm bg-dark text-light border-secondary stylish-select me-2"
                        style="width: auto;">
                        <option value="">-- Pilih Bulan --</option>
                        <?php foreach ($bulanLabels as $i => $label): ?>
                                <option value="<?= $i + 1 ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i + 1) ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                        <?php endforeach; ?>
                    </select>
                    <button id="applyFilter" class="btn btn-gradient-primary btn-sm">
                        <i class="bi bi-funnel me-1"></i>Terapkan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Kartu Saldo Utama -->
        <div class="col-lg-4 mb-3">
            <div class="saldo-card h-100">
                <div class="card-body position-relative">
                    <!-- Header dengan Tombol Mata -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1 pe-4">
                            <h6 class="mb-1 text-white-50">Saldo Tersedia</h6>
                            <h2 class="saldo-amount mb-0" id="saldoAmount"
                                data-value="<?= $saldo['saldo_akhir'] ?? 0 ?>">
                                Rp <?= number_format($saldo['saldo_akhir'] ?? 0, 0, ',', '.') ?>
                            </h2>
                        </div>
                        <!-- Tombol Mata di Posisi yang Tepat -->
                        <button class="btn btn-outline-light btn-sm saldo-toggle" id="toggleSaldo">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>

                    <div class="account-info mt-3">
                        <div class="d-flex justify-content-between">
                            <span><i class="bi bi-calendar-check me-1"></i> Update Terakhir</span>
                            <span
                                class="text-info"><?= date('d M Y', strtotime($saldo['updated_at'] ?? date('Y-m-d'))) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span><i class="bi bi-arrow-up-circle me-1"></i> Transaksi Bulan Ini</span>
                            <span class="text-white"><?= ($kas_masuk_count ?? 0) + ($kas_keluar_count ?? 0) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span><i class="bi bi-person-check me-1"></i> User Aktif</span>
                            <span class="text-white"><?= $total_users ?? 0 ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Transaksi -->
        <div class="col-lg-8 mb-3">
            <div class="bank-card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">Ringkasan Transaksi</h5>
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <div class="summary-box income">
                                <i class="bi bi-arrow-down-circle"></i>
                                <div class="label">Pemasukan</div>
                                <div class="amount">Rp <?= number_format($total_masuk['total'] ?? 0, 0, ',', '.') ?>
                                </div>
                                <span class="badge bg-light text-dark"><?= $kas_masuk_count ?? 0 ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-box expense">
                                <i class="bi bi-arrow-up-circle"></i>
                                <div class="label">Pengeluaran</div>
                                <div class="amount">Rp <?= number_format($total_keluar['total'] ?? 0, 0, ',', '.') ?>
                                </div>
                                <span class="badge bg-light text-dark"><?= $kas_keluar_count ?? 0 ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="summary-box pending">
                                <i class="bi bi-clock-history"></i>
                                <div class="label">Pending</div>
                                <div class="amount"><?= $pengajuan_pending ?></div>
                                <span class="badge bg-light text-dark"><?= $total_pengajuan ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="col-lg-12 mb-5">
        <div class="card-body d-flex flex-column bg-transparent">
            <div class="quick-actions-grid">
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/kas_masuk/create') ?>" class="quick-action-card income">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-plus-circle"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Kas Masuk</div>
                                    <div class="action-desc">Tambah pemasukan ke sistem</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge">Baru</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/kas_keluar') ?>" class="quick-action-card expense">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Kas Keluar</div>
                                    <div class="action-desc">Kelola pengeluaran dana</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge">Update</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/pengajuan') ?>" class="quick-action-card pending">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-list-check"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Pengajuan</div>
                                    <div class="action-desc">Kelola permintaan dana</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge"><?= $pengajuan_pending ?> Pending</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/users') ?>" class="quick-action-card users">
                            <div class="action-content-wrapper">
                                <div class="action-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="action-content">
                                    <div class="action-title">Kelola User</div>
                                    <div class="action-desc">Manajemen pengguna sistem</div>
                                </div>
                            </div>
                            <div class="action-indicator">
                                <span class="action-badge"><?= $total_users ?> User</span>
                                <i class="bi bi-arrow-right action-arrow"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="bank-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Transaksi Terbaru</h5>
                        <div class="transaction-filter">
                            <select class="form-select form-select-sm stylish-select" id="transactionFilter">
                                <option value="all">Semua Transaksi</option>
                                <option value="kas_masuk">Kas Masuk</option>
                                <option value="kas_keluar">Kas Keluar</option>
                                <option value="pengajuan">Pengajuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="transaction-list">
                        <!-- Pengajuan Terbaru -->
                        <div class="transaction-category mb-4" data-type="pengajuan">
                            <h6 class="category-title mb-3">Pengajuan Terbaru</h6>
                            <?php if (empty($pengajuan_terbaru)): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada data pengajuan</p>
                                    </div>
                            <?php else: ?>
                                    <?php foreach ($pengajuan_terbaru as $index => $item): ?>
                                            <div class="transaction-item clickable" 
                                                 data-type="pengajuan" 
                                                 data-id="<?= $item['id'] ?>"
                                                 onclick="showDetailPopup(this)">
                                                <div class="transaction-details">
                                                    <div
                                                        class="transaction-icon <?= $item['tipe'] === 'uang_sendiri' ? 'expense' : 'income' ?>">
                                                        <i
                                                            class="bi <?= $item['tipe'] === 'uang_sendiri' ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                                                    </div>
                                                    <div class="transaction-info">
                                                        <div class="transaction-description"><?= $item['username'] ?> -
                                                            <?= $item['keterangan'] ?></div>
                                                        <div class="transaction-date">
                                                            <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></div>
                                                    </div>
                                                </div>
                                                <div class="transaction-amount">
                                                    <div
                                                        class="amount <?= $item['tipe'] === 'uang_sendiri' ? 'negative' : 'positive' ?>">
                                                        Rp <?= number_format($item['nominal'], 0, ',', '.') ?>
                                                    </div>
                                                    <div class="transaction-status status-<?= $item['status'] ?>">
                                                        <?= ucfirst($item['status']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Kas Masuk Terbaru -->
                        <div class="transaction-category mb-4" data-type="kas_masuk">
                            <h6 class="category-title mb-3">Kas Masuk Terbaru</h6>
                            <?php if (empty($kas_masuk_terbaru)): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada data kas masuk</p>
                                    </div>
                            <?php else: ?>
                                    <?php foreach ($kas_masuk_terbaru as $i => $item): ?>
                                            <div class="transaction-item clickable" 
                                                 data-type="kas_masuk" 
                                                 data-id="<?= $item['id'] ?>"
                                                 onclick="showDetailPopup(this)">
                                                <div class="transaction-details">
                                                    <div class="transaction-icon income">
                                                        <i class="bi bi-arrow-down"></i>
                                                    </div>
                                                    <div class="transaction-info">
                                                        <div class="transaction-description"><?= $item['keterangan'] ?></div>
                                                        <div class="transaction-date">
                                                            <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></div>
                                                    </div>
                                                </div>
                                                <div class="transaction-amount">
                                                    <div class="amount positive">
                                                        Rp <?= number_format($item['nominal'], 0, ',', '.') ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Kas Keluar Terbaru -->
                        <div class="transaction-category" data-type="kas_keluar">
                            <h6 class="category-title mb-3">Kas Keluar Terbaru</h6>
                            <?php if (empty($kas_keluar_terbaru)): ?>
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Tidak ada data kas keluar</p>
                                    </div>
                            <?php else: ?>
                                    <?php foreach ($kas_keluar_terbaru as $i => $item): ?>
                                            <div class="transaction-item clickable" 
                                                 data-type="kas_keluar" 
                                                 data-id="<?= $item['id'] ?>"
                                                 onclick="showDetailPopup(this)">
                                                <div class="transaction-details">
                                                    <div class="transaction-icon expense">
                                                        <i class="bi bi-arrow-up"></i>
                                                    </div>
                                                    <div class="transaction-info">
                                                        <div class="transaction-description"><?= $item['username'] ?? 'System' ?> -
                                                            <?= $item['pengajuan_keterangan'] ?? $item['keterangan'] ?></div>
                                                        <div class="transaction-date">
                                                            <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></div>
                                                    </div>
                                                </div>
                                                <div class="transaction-amount">
                                                    <div class="amount negative">
                                                        Rp <?= number_format($item['nominal'], 0, ',', '.') ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Popup Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Konten detail akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle saldo visibility
        const toggle = document.getElementById('toggleSaldo');
        const amount = document.getElementById('saldoAmount');
        const eye = document.getElementById('eyeIcon');
        let visible = true;

        toggle.addEventListener('click', () => {
            visible = !visible;
            if (visible) {
                amount.textContent = "Rp <?= number_format($saldo['saldo_akhir'] ?? 0, 0, ',', '.') ?>";
                eye.className = "bi bi-eye";
                toggle.classList.remove('btn-light', 'text-dark');
                toggle.classList.add('btn-outline-light');
            } else {
                amount.textContent = "••••••••";
                eye.className = "bi bi-eye-slash";
                toggle.classList.remove('btn-outline-light');
                toggle.classList.add('btn-light', 'text-dark');
            }
        });

        // Filter Transaksi
        const transactionFilter = document.getElementById('transactionFilter');
        const transactionCategories = document.querySelectorAll('.transaction-category');

        transactionFilter.addEventListener('change', function () {
            const selectedValue = this.value;

            transactionCategories.forEach(category => {
                const categoryType = category.getAttribute('data-type');

                if (selectedValue === 'all' || selectedValue === categoryType) {
                    category.style.display = 'block';
                } else {
                    category.style.display = 'none';
                }
            });
        });
    });

    // Fungsi untuk menampilkan popup detail
    function showDetailPopup(element) {
        const type = element.getAttribute('data-type');
        const id = element.getAttribute('data-id');
        
        // Tampilkan loading
        document.getElementById('detailContent').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
        `;
        
        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
        
        // Load data via AJAX
        fetch(`<?= site_url('admin/dashboard/get_detail/') ?>${type}/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('detailContent').innerHTML = data.html;
                    document.getElementById('detailModalLabel').textContent = `Detail ${data.title}`;
                } else {
                    document.getElementById('detailContent').innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> ${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('detailContent').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i> Terjadi kesalahan saat memuat data.
                    </div>
                `;
            });
    }
</script>

<!-- STYLE YANG DISEMPURNAKAN -->
<style>
    :root {
        --primary: #1a73e8;
        --primary-dark: #0d47a1;
        --secondary: #6c757d;
        --success: #4caf50;
        --danger: #f44336;
        --warning: #ff9800;
        --info: #2196f3;
        --dark: #121212;
        --dark-light: #1e1e1e;
        --text: #fff;
        --text-muted: #b0b0b0;
        --border: rgba(255, 255, 255, 0.1);
    }

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        background: linear-gradient(135deg, var(--dark), #1a1a2e);
        color: #fff;
        color: var(--text);
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* Modal Styling */
    .modal-content {
        background: var(--dark-light);
        border-radius: 16px;
        border: 1px solid var(--border);
        color: var(--text);
    }

    .modal-header {
        border-bottom: 1px solid var(--border);
        padding: 20px;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        border-top: 1px solid var(--border);
        padding: 15px 20px;
    }

    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    /* Transaction item clickable */
    .transaction-item.clickable {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .transaction-item.clickable:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        transform: translateX(5px);
    }

    /* Detail Content Styling */
    .detail-section {
        margin-bottom: 20px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border-left: 4px solid var(--primary);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-muted);
    }

    .detail-value {
        text-align: right;
    }

    .amount-large {
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        padding: 15px;
        border-radius: 10px;
        margin: 15px 0;
    }

    .amount-positive {
        background: rgba(76, 175, 80, 0.2);
        color: var(--success);
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .amount-negative {
        background: rgba(239, 83, 80, 0.2);
        color: var(--danger);
        border: 1px solid rgba(239, 83, 80, 0.3);
    }

    /* Kartu Bank */
    .bank-card {
        background: var(--dark-light);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border);
        padding: 24px;
        transition: .3s;
        color: var(--text);
        height: 100%;
    }

    .bank-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    /* Saldo Card - INFORMASI YANG LEBIH RELEVAN */
    .saldo-card {
        background: linear-gradient(135deg, #0d47a1, #1a73e8, #6a11cb);
        border-radius: 18px;
        padding: 20px;
        color: #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        transition: transform .3s;
        position: relative;
        overflow: hidden;
    }

    .saldo-card:hover {
        transform: translateY(-3px);
    }

    .saldo-amount {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        text-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
        line-height: 1.2;
        word-break: break-word;
        min-height: 2.5rem;
        display: flex;
        align-items: center;
    }

    .account-info {
        background: rgba(255, 255, 255, 0.15);
        padding: 12px;
        border-radius: 12px;
        font-size: 0.9rem;
        margin-top: 1rem;
    }

    .account-info span {
        display: flex;
        align-items: center;
    }

    /* Tombol Mata yang Diperbaiki */
    .saldo-toggle {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all .3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-left: 10px;
    }

    .saldo-toggle:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    .saldo-toggle i {
        font-size: 1rem;
        color: #fff;
    }

    .saldo-toggle.btn-light {
        background: rgba(255, 255, 255, 0.9);
        border-color: rgba(255, 255, 255, 0.9);
    }

    .saldo-toggle.btn-light i {
        color: #0d47a1;
    }

    .saldo-toggle.btn-light.text-dark i {
        color: #0d47a1 !important;
    }

    /* Ringkasan Box */
    .summary-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.05);
        text-decoration: none;
        color: inherit;
        transition: 0.3s;
    }

    .summary-box .label {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .summary-box .amount {
        font-size: 1.2rem;
        font-weight: bold;
        margin-top: 6px;
    }

    .summary-box.income {
        color: var(--success);
    }

    .summary-box.expense {
        color: var(--danger);
    }

    .summary-box.pending {
        color: var(--warning);
    }

    .summary-box:hover {
        background: rgba(255, 255, 255, 0.12);
        transform: translateY(-3px);
        text-decoration: none;
        color: inherit;
    }

    .summary-box .badge {
        margin-top: 8px;
    }

    /* AKSI CEPAT */
    .quick-actions-grid {
        flex: 1;
    }

    .quick-action-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        background: var(--dark-light);
        border-radius: 12px;
        text-decoration: none;
        color: var(--text);
        transition: all 0.3s ease;
        border: 1px solid transparent;
        height: 100%;
        min-height: 100px;
    }

    .quick-action-card:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-3px);
        border-color: rgba(255, 255, 255, 0.2);
        text-decoration: none;
        color: var(--text);
    }

    .action-content-wrapper {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .quick-action-card .action-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .quick-action-card.income .action-icon {
        background: rgba(76, 175, 80, 0.15);
        color: var(--success);
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .quick-action-card.expense .action-icon {
        background: rgba(239, 83, 80, 0.15);
        color: var(--danger);
        border: 1px solid rgba(239, 83, 80, 0.3);
    }

    .quick-action-card.pending .action-icon {
        background: rgba(255, 152, 0, 0.15);
        color: var(--warning);
        border: 1px solid rgba(255, 152, 0, 0.3);
    }

    .quick-action-card.users .action-icon {
        background: rgba(33, 150, 243, 0.15);
        color: var(--info);
        border: 1px solid rgba(33, 150, 243, 0.3);
    }

    .quick-action-card:hover .action-icon {
        transform: scale(1.1);
    }

    .action-content {
        flex: 1;
    }

    .action-title {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 4px;
        color: var(--text);
    }

    .action-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .action-indicator {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .action-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-muted);
    }

    .action-arrow {
        color: var(--text-muted);
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .quick-action-card:hover .action-arrow {
        transform: translateX(4px);
        color: var(--text);
    }

    /* Filter & Select - DIPERBARUI dengan border color */
    .filter-card {
        background-color: rgba(26, 26, 26, 0.6);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        padding: 6px 10px;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        background-color: rgba(26, 26, 26, 0.8);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .stylish-select {
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 0.9rem;
        background-color: rgba(26, 26, 26, 0.7);
        border: 2px solid rgba(255, 255, 255, 0.2);
        color: var(--text);
    }

    .stylish-select:focus {
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.2);
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 6px 12px;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .stylish-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Daftar Transaksi */
    .transaction-category {
        margin-bottom: 25px;
    }

    .category-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
    }

    .transaction-list .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s;
    }

    .transaction-list .transaction-item:hover {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .transaction-list .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-details {
        display: flex;
        align-items: center;
    }

    .transaction-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1rem;
    }

    .transaction-icon.income {
        background: rgba(76, 175, 80, 0.15);
        color: var(--success);
        border: 1px solid rgba(76, 175, 80, 0.3);
    }

    .transaction-icon.expense {
        background: rgba(239, 83, 80, 0.15);
        color: var(--danger);
        border: 1px solid rgba(239, 83, 80, 0.3);
    }

    .transaction-info {
        flex: 1;
    }

    .transaction-description {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .transaction-date {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .amount {
        font-weight: 600;
    }

    .amount.positive {
        color: var(--success);
    }

    .amount.negative {
        color: var(--danger);
    }

    .transaction-status {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        margin-top: 4px;
        display: inline-block;
    }

    .status-selesai {
        background: rgba(76, 175, 80, 0.2);
        color: var(--success);
    }

    .status-diterima {
        background: rgba(33, 150, 243, 0.2);
        color: var(--info);
    }

    .status-ditolak {
        background: rgba(239, 83, 80, 0.2);
        color: var(--danger);
    }

    .status-pending {
        background: rgba(255, 152, 0, 0.2);
        color: var(--warning);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 30px;
        color: var(--text-muted);
    }

    .empty-state i {
        font-size: 2rem;
        opacity: .5;
        margin-bottom: 6px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .dashboard-header .date-filter {
            margin-bottom: 15px;
        }

        .quick-action-card {
            min-height: 90px;
            padding: 16px;
        }

        .quick-action-card .action-icon {
            width: 44px;
            height: 44px;
            font-size: 1.3rem;
            margin-right: 12px;
        }

        .transaction-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .transaction-amount {
            margin-top: 8px;
            text-align: left;
            width: 100%;
        }

        .saldo-amount {
            font-size: 1.5rem;
        }

        .saldo-toggle {
            width: 36px;
            height: 36px;
        }

        .modal-dialog {
            margin: 10px;
        }
    }

    @media (max-width: 576px) {
        .quick-action-card {
            flex-direction: column;
            text-align: center;
            padding: 20px 16px;
        }

        .action-content-wrapper {
            flex-direction: column;
            text-align: center;
            margin-bottom: 12px;
        }

        .quick-action-card .action-icon {
            margin-right: 0;
            margin-bottom: 8px;
        }

        .action-indicator {
            flex-direction: row;
            justify-content: center;
            width: 100%;
        }

        .saldo-amount {
            font-size: 1.3rem;
        }

        .saldo-toggle {
            width: 32px;
            height: 32px;
        }

        .detail-row {
            flex-direction: column;
        }

        .detail-value {
            text-align: left;
            margin-top: 5px;
        }
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #4361ee, #3a0ca3);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 500;
        transition: 0.3s ease;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #3a0ca3, #4361ee);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
        color: #fff;
    }

    .btn-gradient-primary:focus {
        background: linear-gradient(135deg, #3a0ca3, #4361ee);
        color: #fff;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
    }

    /* Untuk tombol kecil */
    .btn-gradient-primary.btn-sm {
        height: 38px;
        padding: 8px 16px;
        font-size: 0.875rem;
    }
</style>

<?= $this->endSection() ?>