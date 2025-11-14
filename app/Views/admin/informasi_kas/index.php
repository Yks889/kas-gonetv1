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

        <!-- Filter Bulan - Hanya untuk Status Pengajuan -->
        <form method="get" action="<?= site_url('admin/informasi-kas') ?>" class="d-inline-flex align-items-center">
            <div class="filter-card d-flex align-items-center">
                <span class="text-light me-2 small"><i class="bi bi-calendar3 me-1"></i> Filter Status Pengajuan:</span>
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
                    <a href="<?= site_url('admin/informasi-kas') ?>" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="bi bi-x-circle me-1"></i> Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Diagram Utama -->
    <div class="row">
        <!-- Statistik Bulanan (TETAP data keseluruhan) -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card h-100">
                <!-- Header dengan Summary -->
                <div class="p-4 border-bottom border-secondary">
                    <div class="row">
                        <div class="col">
                            <h5 class="text-steam-blue mb-2">Statistik Bulanan</h5>
                            <div class="summary-stats d-flex gap-4">
                                <div class="stat-item">
                                    <div class="text-white small">Total Kas Masuk</div>
                                    <div class="text-success fw-bold h6 mb-0">
                                        Rp <?= number_format(array_sum($masukData), 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="text-white small">Total Kas Keluar</div>
                                    <div class="text-danger fw-bold h6 mb-0">
                                        Rp <?= number_format(array_sum($keluarData), 0, ',', '.') ?>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="text-white small">Saldo Bersih</div>
                                    <div class="text-white fw-bold h6 mb-0">
                                        Rp
                                        <?= number_format(array_sum($masukData) - array_sum($keluarData), 0, ',', '.') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Legend -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="chart-legend d-flex gap-4">
                            <div class="legend-item d-flex align-items-center">
                                <div class="legend-color me-2"
                                    style="width: 16px; height: 16px; background: linear-gradient(135deg, #7ef29d, #43a047); border-radius: 4px;">
                                </div>
                                <small class="text-light">Kas Masuk</small>
                            </div>
                            <div class="legend-item d-flex align-items-center">
                                <div class="legend-color me-2"
                                    style="width: 16px; height: 16px; background: linear-gradient(135deg, #ef5350, #d32f2f); border-radius: 4px;">
                                </div>
                                <small class="text-light">Kas Keluar</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Container - Diperbaiki dengan padding yang lebih kecil dan tinggi yang optimal -->
                <div class="chart-container-expanded p-3" style="height: 380px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Pengajuan (MENGIKUTI FILTER BULAN) -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100 p-4">
                <!-- Header dengan Overview -->
                <div class="row mb-4">
                    <div class="col">
                        <h5 class="text-steam-blue mb-2">Status Pengajuan
                            <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                                <span class="badge bg-primary ms-2">Bulan:
                                    <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary ms-2">Semua Bulan</span>
                            <?php endif; ?>
                        </h5>
                        <div class="overview-stats">
                            <div class="text-muted small mb-1">
                                <?php if (isset($_GET['bulan']) && $_GET['bulan'] != ''): ?>
                                    Ringkasan Bulan <?= $bulanLabels[$_GET['bulan'] - 1] ?? 'Tidak Diketahui' ?>
                                <?php else: ?>
                                    Ringkasan Keseluruhan
                                <?php endif; ?>
                            </div>
                            <div class="text-white fw-bold h6 mb-0">
                                <?= (int) ($pengajuan_selesai + $pengajuan_pending + $pengajuan_ditolak) ?> Total
                                Pengajuan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagram Donat -->
                <div class="modern-donut-container position-relative mb-4">
                    <div class="d-flex justify-content-center align-items-center position-relative"
                        style="height: 200px;">
                        <canvas id="earningChart"></canvas>
                        <div id="earningCenterText" class="position-absolute text-center">
                            <div class="percentage-display">
                                <h2 class="text-white mb-0 fw-bold"><?= $persentase_pengajuan ?>%</h2>
                                <small class="text-muted">Selesai</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Status -->
                <div class="status-details">
                    <div class="status-header d-flex justify-content-between align-items-center mb-3">
                        <span class="text-light fw-semibold">Detail Status</span>
                        <span class="text-muted small">Persentase</span>
                    </div>

                    <div class="status-item modern-status-item d-flex justify-content-between align-items-center mb-3 p-3 rounded-3"
                        data-status="selesai">
                        <div class="d-flex align-items-center">
                            <div class="status-icon me-3">
                                <i class="bi bi-check-circle-fill" style="color: #66c0f4;"></i>
                            </div>
                            <div>
                                <div class="text-light fw-semibold">Selesai</div>
                                <small class="text-muted">Disetujui</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold h6 mb-1"><?= (int) $pengajuan_selesai ?></div>
                            <div class="progress mini-progress" style="width: 80px; height: 4px;">
                                <div class="progress-bar"
                                    style="background-color: #66c0f4; width: <?= $persentase_pengajuan ?>%"></div>
                            </div>
                            <small class="text-muted"><?= $persentase_pengajuan ?>%</small>
                        </div>
                    </div>

                    <div class="status-item modern-status-item d-flex justify-content-between align-items-center mb-3 p-3 rounded-3"
                        data-status="pending">
                        <div class="d-flex align-items-center">
                            <div class="status-icon me-3">
                                <i class="bi bi-clock-fill" style="color: #ffc107;"></i>
                            </div>
                            <div>
                                <div class="text-light fw-semibold">Pending</div>
                                <small class="text-muted">Menunggu</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold h6 mb-1"><?= (int) $pengajuan_pending ?></div>
                            <?php $persentase_pending = ($pengajuan_selesai + $pengajuan_pending + $pengajuan_ditolak) > 0 ? ($pengajuan_pending / ($pengajuan_selesai + $pengajuan_pending + $pengajuan_ditolak)) * 100 : 0; ?>
                            <div class="progress mini-progress" style="width: 80px; height: 4px;">
                                <div class="progress-bar"
                                    style="background-color: #ffc107; width: <?= $persentase_pending ?>%"></div>
                            </div>
                            <small class="text-muted"><?= number_format($persentase_pending, 1) ?>%</small>
                        </div>
                    </div>

                    <div class="status-item modern-status-item d-flex justify-content-between align-items-center mb-3 p-3 rounded-3"
                        data-status="ditolak">
                        <div class="d-flex align-items-center">
                            <div class="status-icon me-3">
                                <i class="bi bi-x-circle-fill" style="color: #ef5350;"></i>
                            </div>
                            <div>
                                <div class="text-light fw-semibold">Ditolak</div>
                                <small class="text-muted">Tidak disetujui</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold h6 mb-1"><?= (int) $pengajuan_ditolak ?></div>
                            <?php $persentase_ditolak = ($pengajuan_selesai + $pengajuan_pending + $pengajuan_ditolak) > 0 ? ($pengajuan_ditolak / ($pengajuan_selesai + $pengajuan_pending + $pengajuan_ditolak)) * 100 : 0; ?>
                            <div class="progress mini-progress" style="width: 80px; height: 4px;">
                                <div class="progress-bar"
                                    style="background-color: #ef5350; width: <?= $persentase_ditolak ?>%"></div>
                            </div>
                            <small class="text-muted"><?= number_format($persentase_ditolak, 1) ?>%</small>
                        </div>
                    </div>

                    <!-- Summary Footer -->
                    <div class="status-summary mt-4 pt-3 border-top border-secondary">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-success fw-bold h5 mb-1"><?= $persentase_pengajuan ?>%</div>
                                <small class="text-muted">Rate</small>
                            </div>
                            <div class="col-4">
                                <div class="text-warning fw-bold h5 mb-1">
                                    <?= number_format($persentase_pending, 1) ?>%
                                </div>
                                <small class="text-muted">Pending</small>
                            </div>
                            <div class="col-4">
                                <div class="text-danger fw-bold h5 mb-1">
                                    <?= number_format($persentase_ditolak, 1) ?>%
                                </div>
                                <small class="text-muted">Rejection</small>
                            </div>
                        </div>
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

    // Modern Bar Chart untuk Statistik Bulanan (TETAP data keseluruhan)
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                label: 'Kas Masuk',
                data: <?= json_encode($masukData) ?>,
                backgroundColor: (context) => {
                    const chart = context.chart;
                    const { ctx, chartArea } = chart;
                    if (!chartArea) return null;

                    const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    gradient.addColorStop(0, 'rgba(102, 244, 102, 0.7)');   // hijau muda di bawah
                    gradient.addColorStop(0.7, 'rgba(76, 175, 80, 0.9)');   // hijau tengah
                    gradient.addColorStop(1, 'rgba(56, 142, 60, 1)');       // hijau tua di atas
                    return gradient;
                },
                borderColor: 'rgba(76, 175, 80, 1)', // hijau utama
                borderWidth: 0,
                borderRadius: {
                    topLeft: 8,
                    topRight: 8,
                    bottomLeft: 0,
                    bottomRight: 0
                },
                borderSkipped: false,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            },
            {
                label: 'Kas Keluar',
                data: <?= json_encode($keluarData) ?>,
                backgroundColor: (context) => {
                    const chart = context.chart;
                    const { ctx, chartArea } = chart;
                    if (!chartArea) return null;

                    const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    gradient.addColorStop(0, 'rgba(239, 83, 80, 0.7)');
                    gradient.addColorStop(0.7, 'rgba(239, 83, 80, 0.9)');
                    gradient.addColorStop(1, 'rgba(211, 47, 47, 1)');
                    return gradient;
                },
                borderColor: 'rgba(239, 83, 80, 1)',
                borderWidth: 0,
                borderRadius: {
                    topLeft: 8,
                    topRight: 8,
                    bottomLeft: 0,
                    bottomRight: 0
                },
                borderSkipped: false,
                barPercentage: 0.7,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 26, 26, 0.95)',
                    titleColor: '#c7d5e0',
                    bodyColor: '#c7d5e0',
                    borderColor: 'rgba(102, 192, 244, 0.4)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    usePointStyle: true,
                    boxPadding: 6,
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
                        color: 'rgba(199,213,224,0.1)',
                        drawBorder: false,
                        drawTicks: false
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
                        color: 'rgba(199,213,224,0.05)',
                        drawBorder: false,
                        drawTicks: false
                    },
                    ticks: {
                        color: '#8f98a0',
                        padding: 8,
                        font: {
                            size: 11,
                            weight: '500'
                        }
                    },
                    border: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });

    // Modern Doughnut Chart untuk Status Pengajuan (MENGIKUTI FILTER)
    new Chart(document.getElementById('earningChart'), {
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
                    'rgba(102, 192, 244, 0.9)',
                    'rgba(255, 193, 7, 0.9)',
                    'rgba(239, 83, 80, 0.9)'
                ],
                borderColor: [
                    'rgba(102, 192, 244, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(239, 83, 80, 1)'
                ],
                borderWidth: 3,
                borderRadius: [12, 12, 12],
                spacing: 4,
                hoverOffset: 15,
                hoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 26, 26, 0.95)',
                    titleColor: '#c7d5e0',
                    bodyColor: '#c7d5e0',
                    borderColor: 'rgba(102, 192, 244, 0.4)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    usePointStyle: true,
                    boxPadding: 6,
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
                duration: 1200,
                easing: 'easeOutQuart'
            }
        }
    });

    // Interaktivitas pada status items
    document.querySelectorAll('.modern-status-item').forEach(item => {
        item.addEventListener('mouseenter', function () {
            const status = this.getAttribute('data-status');
            const chart = Chart.getChart('earningChart');
            if (chart) {
                const dataIndex = ['selesai', 'pending', 'ditolak'].indexOf(status);
                chart.setActiveElements([{ datasetIndex: 0, index: dataIndex }]);
                chart.update();
            }
        });

        item.addEventListener('mouseleave', function () {
            const chart = Chart.getChart('earningChart');
            if (chart) {
                chart.setActiveElements([]);
                chart.update();
            }
        });
    });
</script>

<style>
    /* Improved Layout Styles */
    .summary-stats {
        border-left: 2px solid rgba(102, 192, 244, 0.3);
        padding-left: 1rem;
    }

    .stat-item {
        padding: 0.5rem 0;
    }

    .stat-item:not(:last-child) {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        padding-right: 1rem;
    }

    .overview-stats {
        background: rgba(102, 192, 244, 0.1);
        padding: 0.75rem;
        border-radius: 8px;
        border-left: 3px solid #66c0f4;
    }

    .status-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0.75rem;
    }

    .status-summary {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        padding: 1rem;
    }

    .status-summary .col-4:not(:last-child) {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Enhanced modern status items */
    .modern-status-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .modern-status-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
        transition: left 0.5s ease;
    }

    .modern-status-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        border-color: rgba(102, 192, 244, 0.2);
        background: rgba(255, 255, 255, 0.05);
    }

    .modern-status-item:hover::before {
        left: 100%;
    }

    .status-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.08);
        font-size: 1.2rem;
    }

    .mini-progress {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
    }

    /* Enhanced bar chart styling */
    .chart-legend .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }

    /* PERBAIKAN: Chart container untuk diagram batang yang lebih optimal */
    .chart-container-expanded {
        position: relative;
        background: linear-gradient(145deg, rgba(26, 26, 26, 0.7), rgba(40, 40, 40, 0.7));
        border-radius: 0 0 12px 12px;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.05),
            0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top: none;
        height: 380px !important;
        padding: 1rem !important;
    }

    /* Memastikan canvas chart memenuhi container */
    .chart-container-expanded canvas {
        width: 100% !important;
        height: 100% !important;
    }

    .modern-donut-container {
        background: linear-gradient(145deg, rgba(26, 26, 26, 0.7), rgba(40, 40, 40, 0.7));
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.05),
            0 8px 32px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .percentage-display {
        background: rgba(26, 26, 26, 0.8);
        border-radius: 50%;
        width: 100px;
        height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* PERBAIKAN: Layout dashboard card untuk diagram batang */
    .dashboard-card {
        background: linear-gradient(145deg, rgba(33, 33, 33, 0.9), rgba(26, 26, 26, 0.9));
        border-radius: 16px;
        box-shadow:
            0 4px 20px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    /* Header dipisah dari chart container */
    .dashboard-card .p-4.border-bottom {
        flex-shrink: 0;
    }

    /* Chart container mengisi sisa ruang */
    .chart-container-expanded {
        flex: 1;
        min-height: 0;
        /* Penting untuk flexbox di beberapa browser */
    }

    /* Smooth animations */
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

    @keyframes slideInFromLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInFromRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .dashboard-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .summary-stats {
        animation: slideInFromLeft 0.8s ease-out;
    }

    .overview-stats {
        animation: slideInFromRight 0.8s ease-out;
    }

    /* Improved responsive design */
    @media (max-width: 768px) {
        .summary-stats {
            flex-direction: column;
            gap: 1rem !important;
            border-left: none;
            padding-left: 0;
        }

        .stat-item:not(:last-child) {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-right: 0;
            padding-bottom: 1rem;
        }

        .chart-legend {
            flex-direction: column;
            gap: 0.5rem !important;
        }

        .status-summary .col-4 {
            margin-bottom: 1rem;
        }

        .status-summary .col-4:not(:last-child) {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 1rem;
        }

        .percentage-display {
            width: 80px;
            height: 80px;
        }

        .percentage-display h2 {
            font-size: 1.5rem;
        }

        /* Responsive height untuk chart */
        .chart-container-expanded {
            height: 300px !important;
        }
    }

    /* Enhanced visual effects */
    .dashboard-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg,
                transparent,
                rgba(102, 192, 244, 0.4),
                transparent);
    }

    /* Custom scrollbar for webkit browsers */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(26, 26, 26, 0.8);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(102, 192, 244, 0.6);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(102, 192, 244, 0.8);
    }
</style>

<?= $this->endSection() ?>