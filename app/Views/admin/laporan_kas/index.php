<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-white">
                <i class="bi bi-graph-up me-2"></i> Laporan Kas
            </h1>
            <p class="text-muted mb-0">Monitor keuangan dan status pengajuan secara real-time</p>
        </div>

        <!-- Filter Bulan - Untuk Status Pengajuan dan Card -->
        <form method="get" action="<?= site_url('admin/laporan-kas') ?>" class="d-inline-flex align-items-center">
            <div class="filter-card d-flex align-items-center">
                <span class="text-light me-2 small"><i class="bi bi-calendar3 me-1"></i> Filter:</span>
                <select name="bulan"
                    class="form-select form-select-sm bg-dark text-light border-secondary stylish-select me-2"
                    style="width: auto;">
                    <option value="">-- Semua Bulan --</option>
                    <?php foreach ($bulanLabels as $i => $label): ?>
                        <option value="<?= $i + 1 ?>" <?= (isset($_GET['bulan']) && $_GET['bulan'] == $i + 1) ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-sm btn-outline-light stylish-btn">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>
                <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                    <a href="<?= site_url('admin/laporan-kas') ?>" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <!-- Total Kas Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-arrow-down-circle text-success"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Kas Masuk</h5>
                        <h3 class="card-value text-success mb-0">
                            Rp <?= number_format($total_masuk_filter, 0, ',', '.') ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                            Kas masuk bulan <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?>
                        <?php else: ?>
                            Total semua kas masuk
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Kas Keluar -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-arrow-up-circle text-danger"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Kas Keluar</h5>
                        <h3 class="card-value text-danger mb-0">
                            Rp <?= number_format($total_keluar_filter, 0, ',', '.') ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                            Kas keluar bulan <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?>
                        <?php else: ?>
                            Total semua kas keluar
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Saldo Bersih -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-wallet2 text-steam-blue"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Saldo Bersih</h5>
                        <h3 class="card-value text-steam-blue mb-0">
                            Rp <?= number_format($saldo_bersih_filter, 0, ',', '.') ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                            Saldo bulan <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?>
                        <?php else: ?>
                            Selisih kas masuk dan keluar
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Total Pengajuan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon me-3">
                        <i class="bi bi-file-text text-warning"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title text-white mb-1">Total Pengajuan</h5>
                        <h3 class="card-value text-warning mb-0">
                            <?= (int) ($pengajuan_selesai + $pengajuan_pending + $pengajuan_ditolak) ?>
                        </h3>
                    </div>
                </div>
                <div class="card-footer mt-3 pt-3 border-top border-secondary">
                    <small class="text-white">
                        <i class="bi bi-info-circle me-1"></i>
                        <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                            Pengajuan bulan <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?>
                        <?php else: ?>
                            Jumlah semua pengajuan
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row">
        <!-- Combined Chart -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="text-white mb-0">Statistik Keuangan Bulanan</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 320px;">
                        <canvas id="combinedChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pengajuan -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100">
                <div class="card-header">
                    <h5 class="text-white mb-0">Status Pengajuan
                        <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                            <span class="badge bg-primary ms-2">Bulan:
                                <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary ms-2">Semua Bulan</span>
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="donut-container mb-4">
                        <canvas id="statusChart"></canvas>
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

    // Combined Chart (Bar Chart)
    new Chart(document.getElementById('combinedChart'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [
                {
                    label: 'Kas Masuk',
                    data: <?= json_encode($masukData) ?>,
                    backgroundColor: 'rgba(102, 192, 244, 0.8)',
                    borderColor: 'rgba(102, 192, 244, 0.8)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.6,
                },
                {
                    label: 'Kas Keluar',
                    data: <?= json_encode($keluarData) ?>,
                    backgroundColor: 'rgba(239, 83, 80, 0.8)',
                    borderColor: 'rgba(239, 83, 80, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barPercentage: 0.6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#c7d5e0',
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 26, 26, 0.95)',
                    titleColor: '#c7d5e0',
                    bodyColor: '#c7d5e0',
                    borderColor: 'rgba(102, 192, 244, 0.5)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxPadding: 5,
                    callbacks: {
                        label: function (context) {
                            return `${context.dataset.label}: Rp ${context.parsed.y.toLocaleString('id-ID')}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(199,213,224,0.15)',
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#8f98a0',
                        padding: 8,
                        font: {
                            size: 11
                        },
                        callback: function (value) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                            }
                            if (value >= 1000) {
                                return 'Rp ' + (value / 1000).toFixed(0) + 'Rb';
                            }
                            return 'Rp ' + value;
                        }
                    },
                    border: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(199,213,224,0.08)',
                        drawBorder: false,
                    },
                    ticks: {
                        color: '#8f98a0',
                        padding: 8,
                        font: {
                            size: 11
                        }
                    },
                    border: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            },
            interaction: {
                mode: 'index',
                intersect: false
            }
        }
    });

    // Status Chart (Doughnut)
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Pending', 'Ditolak'],
            datasets: [{
                data: [
                    <?= (int) ($pengajuan_selesai) ?>,
                    <?= (int) $pengajuan_pending ?>,
                    <?= (int) $pengajuan_ditolak ?>
                ],
                backgroundColor: [
                    'rgba(102, 192, 244, 0.8)',
                    'rgba(255, 193, 7, 0.9)',
                    'rgba(239, 83, 80, 0.9)'
                ],
                borderColor: [
                    'rgba(102, 192, 244, 0.8)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(239, 83, 80, 1)'
                ],
                borderWidth: 3,
                borderRadius: 10,
                spacing: 6,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#c7d5e0',
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 26, 26, 0.95)',
                    titleColor: '#c7d5e0',
                    bodyColor: '#c7d5e0',
                    borderColor: 'rgba(102, 192, 244, 0.5)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxPadding: 5,
                    callbacks: {
                        label: function (context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
</script>

<style>
    /* Dashboard Cards */
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.8);
        border-color: rgba(67, 97, 238, 0.3);
    }

    .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        font-size: 1.8rem;
    }

    .card-title {
        font-size: 0.9rem;
        font-weight: 500;
        color: #aaa;
    }

    .card-value {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .card-footer {
        border-top-color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Text Colors */
    .text-success {
        color: #06d6a0 !important;
    }

    .text-danger {
        color: #ef5350 !important;
    }

    .text-primary {
        color: #4361ee !important;
    }

    .text-warning {
        color: #ffb300 !important;
    }

    .text-steam-blue {
        color: #66c0f4;
    }

    /* Chart Containers */
    .chart-container {
        position: relative;
        height: 320px;
    }

    .donut-container {
        position: relative;
        height: 280px;
        margin-bottom: 1rem;
    }

    /* Chart Legends */
    .chart-legend .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }

    /* Form Elements */
    .stylish-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .stylish-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.25);
        background: rgba(255, 255, 255, 0.08);
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .stylish-btn:hover {
        background: #4361ee;
        border-color: #4361ee;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    /* Filter Card */
    .filter-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 0.75rem 1rem;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dashboard-card {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .chart-container {
            height: 250px;
        }

        .donut-container {
            height: 220px;
        }

        .dashboard-card .card-header {
            padding: 1rem;
        }

        .dashboard-card .card-body {
            padding: 1rem;
        }

        .filter-card {
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-card .d-flex {
            justify-content: center;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .card-value {
            font-size: 1.5rem;
        }
    }

    /* Badges */
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-weight: 500;
    }

    .bg-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4) !important;
    }

    .bg-secondary {
        background: linear-gradient(135deg, #6c757d, #5a6268) !important;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(102, 192, 244, 0.8);
        background: ;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(102, 192, 244, 0.8);
        background: ;
    }
</style>

<?= $this->endSection() ?>