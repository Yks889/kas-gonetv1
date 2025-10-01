<?= $this->extend('layouts/user') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-12">
            <h1 class="h3 mb-0 text-white">Dashboard User</h1>
            <p class="text-light mb-0">Ringkasan pengajuan dan statistik akun Anda</p>
        </div>
    </div>

    <!-- Ringkasan Pengajuan -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-list-check"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Total Pengajuan</h6>
                        <h3 class="text-white mb-0"><?= $total_pengajuan ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-primary bg-opacity-25 text-primary">
                        <i class="bi bi-file-earmark-text me-1"></i> Semua pengajuan
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-check-circle"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Diterima</h6>
                        <h3 class="text-white mb-0"><?= $pengajuan_diterima ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-25 text-success">
                        <i class="bi bi-check-lg me-1"></i> Pengajuan disetujui
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-clock-history"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Pending</h6>
                        <h3 class="text-white mb-0"><?= $pengajuan_pending ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-warning bg-opacity-25 text-warning">
                        <i class="bi bi-hourglass-split me-1"></i> Menunggu persetujuan
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card h-100 p-4">
                <div class="d-flex align-items-center">
                    <div class="card-icon"><i class="bi bi-x-circle"></i></div>
                    <div class="ms-3">
                        <h6 class="text-steam-blue mb-1">Ditolak</h6>
                        <h3 class="text-white mb-0"><?= $pengajuan_ditolak ?></h3>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-danger bg-opacity-25 text-danger">
                        <i class="bi bi-exclamation-triangle me-1"></i> Pengajuan ditolak
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Utama - Status Pengajuan & Aksi Cepat (UKURAN DIKECILKAN) -->
    <div class="row mb-4">
        <!-- Status Pengajuan -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100 p-3">
                <h5 class="text-steam-blue mb-3">Status Pengajuan</h5>
                <div class="d-flex justify-content-center align-items-center position-relative" style="height: 180px;">
                    <canvas id="statusChart"></canvas>
                    <div id="statusCenterText" class="position-absolute text-center">
                        <h4 class="text-white mb-0">
                            <?= $total_pengajuan > 0 ? round(($pengajuan_diterima / $total_pengajuan) * 100, 1) : 0 ?>%
                        </h4>
                        <small class="text-light">Diterima</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card h-100 p-3">
                <h5 class="text-steam-blue mb-3">Aksi Cepat</h5>
                <div class="row g-2">
                    <!-- Kotak kiri atas -->
                    <div class="col-md-6">
                        <a href="<?= site_url('user/pengajuan') ?>"
                            class="btn btn-info text-light w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-list-ul  display-5 mb-1"></i>
                            <span class="text-center">Lihat Pengajuan</span>
                        </a>
                    </div>

                    <!-- Kotak kanan atas -->
                    <div class="col-md-6">
                        <a href="<?= site_url('user/profile') ?>"
                            class="btn btn-success w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-person display-5 mb-1"></i>
                            <span class="text-center">Profil Saya</span>
                        </a>
                    </div>

                    <!-- Kotak besar bawah -->
                    <div class="col-md-12 mt-3">
                        <a href="<?= site_url('user/pengajuan/create') ?>"
                            class="btn btn-primary w-100 h-100 py-3 d-flex flex-column align-items-center justify-content-center stylish-btn">
                            <i class="bi bi-plus-circle display-5 mb-1"></i>
                            <span class="text-center">Ajukan Kas Baru</span>
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
    // Data untuk chart status pengajuan
    const statusData = {
        labels: ['Diterima', 'Pending', 'Ditolak'],
        datasets: [{
            data: [
                <?= (int) $pengajuan_diterima ?>,
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

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: statusData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#c7d5e0',
                        padding: 10,
                        font: {
                            size: 11
                        }
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

    #statusCenterText {
        font-size: 1.2rem;
        font-weight: bold;
        color: #66c0f4;
    }

    #statusCenterText small {
        font-size: 0.7rem;
        color: #c7d5e0;
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .stylish-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
    }

    .stylish-btn i {
        font-size: 2rem;
    }

    .stylish-btn span {
        font-size: 0.95rem;
        font-weight: 600;
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

    /* Supaya isi card tetap rapi */
    .dashboard-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        word-wrap: break-word;
        overflow: hidden;
        /* cegah isi keluar */
    }

    /* Ikon di kiri dan teks di kanan biar tetap fleksibel */
    .dashboard-card .d-flex {
        flex-wrap: wrap;
        /* biar kalau sempit, teks turun */
    }

    /* Batasi ukuran teks supaya tidak melebihi container */
    .dashboard-card h3,
    .dashboard-card h6,
    .dashboard-card span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        /* teks panjang dipotong dengan "..." */
    }

    /* Kalau layar kecil, teks jangan dipotong, biar turun ke bawah */
    @media (max-width: 576px) {
        .dashboard-card {
            padding: 1.2rem;
            /* agak longgar di HP */
        }

        .dashboard-card h3 {
            font-size: 1.4rem;
            /* biar angka tidak terlalu besar */
        }

        .dashboard-card h6 {
            font-size: 0.9rem;
        }
    }
</style>

<?= $this->endSection() ?>