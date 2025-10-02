<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-white">
                <i class="bi bi-graph-up me-2"></i> Laporan Kas
            </h1>
        </div>

        <!-- Filter Bulan -->
        <form method="get" action="<?= site_url('admin/informasi-kas') ?>" class="d-inline-flex align-items-center">
            <div class="filter-card d-flex align-items-center">
                <span class="text-light me-2 small"><i class="bi bi-calendar3 me-1"></i> Filter:</span>
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
                <button type="submit" class="btn btn-sm btn-outline-light stylish-btn">
                    <i class="bi bi-funnel me-1"></i> Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Diagram Utama -->
    <div class="row">
        <!-- Diagram Batang - Statistik Bulanan -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-steam-blue mb-0">Statistik Bulanan</h5>
                </div>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Diagram Lingkaran - Status Pengajuan -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100 p-4">
                <h5 class="text-steam-blue mb-3">Status Pengajuan</h5>
                <div class="d-flex justify-content-center align-items-center position-relative" style="height: 300px;">
                    <canvas id="earningChart"></canvas>
                    <div id="earningCenterText" class="position-absolute text-center">
                        <h2 class="text-white mb-0"><?= $persentase_pengajuan ?>%</h2>
                        <small class="text-muted">Selesai</small>
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
                <?= (int) ($pengajuan_selesai) ?>,
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
        padding: 8px 16px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
    }

    .stylish-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .filter-card {
        background-color: rgba(26, 26, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.2);
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
        color: #fff;
    }

    .stylish-select:focus {
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.2);
    }

   .border-bottom {
    border-bottom: 2px solid rgba(255, 255, 255, 0.8) !important;
}


    /* Garis pada dashboard card */
    .dashboard-card {
        border: 2px solid rgba(255, 255, 255, 0.1);
    }

    /* Garis pada chart containers */
    .chart-container {
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        padding: 10px;
        background: rgba(255, 255, 255, 0.02);
    }

    /* Garis pada filter card */
    .filter-card {
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    /* Garis pada select elements */
    .stylish-select {
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .stylish-select:focus {
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    /* Garis pada buttons */
    .stylish-btn {
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .stylish-btn:hover {
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    /* Garis pada diagram lingkaran */
    #earningChart {
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        padding: 5px;
    }

    /* Garis pemisah antara diagram */
    .row .col-lg-8,
    .row .col-lg-4 {
        position: relative;
    }

    /* Optional: Tambahkan garis vertikal pemisah antara diagram */
    @media (min-width: 992px) {
        .row .col-lg-8:after {
            content: '';
            position: absolute;
            right: -10px;
            top: 20px;
            bottom: 20px;
            width: 1px;
            background: rgba(255, 255, 255, 0.1);
        }
    }
</style>

<?= $this->endSection() ?>