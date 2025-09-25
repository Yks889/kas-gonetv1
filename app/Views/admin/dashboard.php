<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header dengan Filter -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="h3 mb-0 text-white">Dashboard Admin</h1>
            <p class="text-light mb-0">Ringkasan keuangan dan statistik sistem</p>
        </div>
        <div class="col-md-6 text-md-end mt-2 mt-md-0">
            <!-- Filter Bulan -->
            <form method="get" action="<?= site_url('admin/dashboard') ?>" class="d-inline-flex align-items-center">
                <div class="filter-card d-flex align-items-center">
                    <span class="text-light me-2 small"><i class="bi bi-calendar3 me-1"></i> Filter:</span>
                    <select name="bulan"
                        class="form-select form-select-sm bg-dark text-light border-steam stylish-select me-2"
                        style="width: auto;">
                        <option value="">-- Pilih Bulan --</option>
                        <?php foreach ($bulanLabels as $i => $label): ?>
                            <option value="<?= $i + 1 ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i + 1) ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary stylish-btn">
                        <i class="bi bi-funnel me-1"></i> Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan Kas -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-wallet2"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Saldo Kas</h6>
                        <h3 class="text-white mb-0">Rp <?= number_format($saldo['saldo_akhir'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-25 text-success">
                        <i class="bi bi-arrow-up me-1"></i> Saldo terkini
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-arrow-down-circle"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Total Pemasukan</h6>
                        <h3 class="text-white mb-0">Rp <?= number_format($total_masuk['total'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-primary bg-opacity-25 text-primary">
                        <i class="bi bi-cash-coin me-1"></i> Pemasukan bulan ini
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-arrow-up-circle"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Total Pengeluaran</h6>
                        <h3 class="text-white mb-0">Rp <?= number_format($total_keluar['total'] ?? 0, 0, ',', '.') ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-danger bg-opacity-25 text-danger">
                        <i class="bi bi-currency-exchange me-1"></i> Pengeluaran bulan ini
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik & Aksi -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-steam-blue mb-0">Statistik Bulanan</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-steam active" data-bs-toggle="button">Bulanan</button>
                        <button type="button" class="btn btn-sm btn-outline-steam" data-bs-toggle="button">Tahunan</button>
                    </div>
                </div>
                <div class="chart-container" style="height: 300px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100 p-4">
                <h5 class="text-steam-blue mb-3">Statistik Pengguna</h5>
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="p-3 bg-steam-dark rounded">
                            <h3 class="text-primary mb-0"><?= $total_users ?></h3>
                            <small class="text-white">Total User</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="p-3 bg-steam-dark rounded">
                            <h3 class="text-success mb-0"><?= $total_pengajuan ?></h3>
                            <small class="text-white">Total Pengajuan</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-steam-dark rounded">
                            <h3 class="text-warning mb-0"><?= $pengajuan_pending ?></h3>
                            <small class="text-white">Pending</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-steam-dark rounded">
                            <h3 class="text-danger mb-0"><?= $pengajuan_ditolak ?></h3>
                            <small class="text-white">Ditolak</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagram & Aksi Cepat -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card h-100 p-4">
                <h5 class="text-steam-blue mb-3">Status Pengajuan</h5>
                <div class="d-flex justify-content-center align-items-center position-relative" style="height: 250px;">
                    <canvas id="earningChart"></canvas>
                    <div id="earningCenterText" class="position-absolute text-center">
                        <h2 class="text-white mb-0"><?= $persentase_pengajuan ?>%</h2>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card h-100 p-4">
                <h5 class="text-steam-blue mb-3">Aksi Cepat</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/kas_masuk/create') ?>"
                            class="btn btn-primary w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-plus-circle display-6 mb-2"></i>
                            <span>Tambah Kas Masuk</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/pengajuan') ?>"
                            class="btn btn-warning w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-list-check display-6 mb-2"></i>
                            <span>Lihat Pengajuan</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/kas_keluar/create') ?>"
                            class="btn btn-info w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-cash-stack display-6 mb-2"></i>
                            <span>Kas Keluar</span>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= site_url('admin/users') ?>"
                            class="btn btn-success w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-people display-6 mb-2"></i>
                            <span>Kelola User</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthLabels = <?= json_encode($bulanLabels) ?>;
    const monthlyData = {
        labels: monthLabels,
        datasets: [{
                label: 'Kas Masuk',
                data: <?= json_encode($masukData) ?>,
                backgroundColor: 'rgba(102, 192, 244, 0.8)',
                borderColor: 'rgba(102, 192, 244, 1)',
                borderWidth: 2,
                borderRadius: 6,
                fill: true,
                tension: 0.4
            },
            {
                label: 'Kas Keluar',
                data: <?= json_encode($keluarData) ?>,
                backgroundColor: 'rgba(239, 83, 80, 0.8)',
                borderColor: 'rgba(239, 83, 80, 1)',
                borderWidth: 2,
                borderRadius: 6,
                fill: true,
                tension: 0.4
            }
        ]
    };

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: monthlyData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#c7d5e0'
                    }
                },
                title: {
                    display: true,
                    text: 'Statistik Kas Bulanan',
                    color: '#c7d5e0'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(199,213,224,0.1)'
                    },
                    ticks: {
                        color: '#c7d5e0'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(199,213,224,0.1)'
                    },
                    ticks: {
                        color: '#c7d5e0'
                    }
                }
            }
        }
    });

    const pengajuanData = {
        labels: ['Selesai', 'Pending', 'Ditolak'],
        datasets: [{
            data: [
                <?= (int) ($total_pengajuan - $pengajuan_pending - $pengajuan_ditolak) ?>,
                <?= (int) $pengajuan_pending ?>,
                <?= (int) $pengajuan_ditolak ?>
            ],
            backgroundColor: [
                'rgba(102, 192, 244, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(239, 83, 80, 0.8)'
            ],
            borderColor: [
                'rgba(102, 192, 244, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(239, 83, 80, 1)'
            ],
            borderWidth: 2,
            hoverOffset: 10
        }]
    };

    new Chart(document.getElementById('earningChart'), {
        type: 'doughnut',
        data: pengajuanData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#c7d5e0',
                        padding: 15
                    }
                }
            }
        }
    });
</script>

<style>
    .bg-steam-dark {
        background-color: rgba(42, 71, 94, 0.5);
    }

    .border-steam {
        border-color: rgba(102, 192, 244, 0.2) !important;
    }

    .btn-outline-steam {
        color: #66c0f4;
        border-color: rgba(102, 192, 244, 0.3);
    }

    .btn-outline-steam:hover,
    .btn-outline-steam.active {
        background-color: rgba(102, 192, 244, 0.15);
        color: white;
        border-color: rgba(102, 192, 244, 0.5);
    }

    .text-steam-blue {
        color: #66c0f4;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        background-color: rgba(102, 192, 244, 0.15);
        color: #66c0f4;
    }

    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    #earningCenterText {
        font-size: 1.5rem;
        font-weight: bold;
        color: #66c0f4;
    }

    #earningCenterText small {
        font-size: 0.8rem;
        color: #c7d5e0;
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stylish-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .filter-card {
        background-color: rgba(26, 26, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.2);
        /* abu-abu transparan */
        border-radius: 10px;
        padding: 6px 10px;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        background-color: rgba(26, 26, 26, 0.8);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
    }

    .stylish-select {
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 0.9rem;
        background-color: rgba(26, 26, 26, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.2);
        /* abu-abu transparan */
        color: #fff;
    }

    .stylish-select:focus {
        border-color: rgba(255, 255, 255, 0.5);
        /* tetap abu-abu, bukan biru */
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.2);
    }
</style>

<?= $this->endSection() ?>