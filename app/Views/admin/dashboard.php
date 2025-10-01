<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="header-gradient mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2 text-white">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
                </h1>
                <p class="mb-0 text-light">Ringkasan lengkap pengelolaan kas sistem GoNet</p>
            </div>
            
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
        <!-- Saldo Card -->
        <div class="col-md-4 mb-3">
            <div class="card saldo-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="mb-1 text-light opacity-75">Saldo Tersedia</h6>
                            <h2 class="saldo-amount" id="saldoAmount">
                                Rp <?= number_format($saldo['saldo_akhir'] ?? 0, 0, ',', '.') ?>
                            </h2>
                        </div>
                        <button class="btn btn-outline-light btn-sm" id="toggleSaldo">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="saldo-info">
                                <div class="saldo-info-icon bg-success"><i class="bi bi-arrow-down"></i></div>
                                <small>Pemasukan</small>
                                <p class="fw-bold mb-0">Rp <?= number_format($total_masuk['total'] ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="saldo-info">
                                <div class="saldo-info-icon bg-danger"><i class="bi bi-arrow-up"></i></div>
                                <small>Pengeluaran</small>
                                <p class="fw-bold mb-0">Rp <?= number_format($total_keluar['total'] ?? 0, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="saldo-info">
                                <div class="saldo-info-icon bg-info"><i class="bi bi-list-check"></i></div>
                                <small>Total Transaksi</small>
                                <p class="fw-bold mb-0"><?= $total_pengajuan + ($kas_masuk_count ?? 0) + ($kas_keluar_count ?? 0) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pengguna -->
        <div class="col-md-4 mb-3">
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
                    <div class="col-6 mb-3">
                        <div class="p-3 bg-steam-dark rounded">
                            <h3 class="text-warning mb-0"><?= $pengajuan_pending ?></h3>
                            <small class="text-white">Pending</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="p-3 bg-steam-dark rounded">
                            <h3 class="text-danger mb-0"><?= $pengajuan_ditolak ?></h3>
                            <small class="text-white">Ditolak</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pengajuan -->
        <div class="col-md-4 mb-3">
            <div class="dashboard-card h-100 p-4">
                <h5 class="text-steam-blue mb-3">Status Pengajuan</h5>
                <div class="d-flex justify-content-center align-items-center position-relative" style="height: 200px;">
                    <canvas id="earningChart"></canvas>
                    <div id="earningCenterText" class="position-absolute text-center">
                        <h2 class="text-white mb-0"><?= $persentase_pengajuan ?>%</h2>
                        <small class="text-muted">Selesai</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik & Aksi Cepat -->
    <div class="row mb-4">
        <!-- Grafik Statistik -->
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

        <!-- Aksi Cepat -->
        <div class="col-lg-4 mb-4">
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

    <!-- Tabs Transaksi -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pengajuan"><i class="bi bi-clipboard-check me-2"></i>Pengajuan</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#masuk"><i class="bi bi-cash-coin me-2"></i>Kas Masuk</button></li>
                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#keluar"><i class="bi bi-cash-stack me-2"></i>Kas Keluar</button></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <!-- Tab Pengajuan -->
                        <div class="tab-pane fade show active" id="pengajuan">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead><tr><th>#</th><th>User</th><th>Nominal</th><th>Keterangan</th><th>Tipe</th><th>Status</th><th>Tanggal</th></tr></thead>
                                    <tbody>
                                        <?php if (empty($pengajuan)): ?>
                                            <tr><td colspan="7" class="empty-state"><i class="bi bi-inbox"></i><p>Tidak ada data pengajuan</p></td></tr>
                                        <?php else: foreach ($pengajuan as $index => $item): ?>
                                            <tr>
                                                <td class="fw-bold"><?= $index+1 ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar"><?= substr($item['username'],0,1) ?></div>
                                                        <?= $item['username'] ?>
                                                    </div>
                                                </td>
                                                <td class="fw-bold">Rp <?= number_format($item['nominal'],0,',','.') ?></td>
                                                <td><?= $item['keterangan'] ?></td>
                                                <td><span class="status-badge bg-<?= $item['tipe']==='uang_sendiri'?'warning':'info' ?>"><?= $item['tipe']==='uang_sendiri'?'Uang Sendiri':'Minta Uang' ?></span></td>
                                                <td><span class="status-badge bg-<?=
                                                    $item['status']==='selesai'?'success':
                                                    ($item['status']==='diterima'?'primary':
                                                    ($item['status']==='ditolak'?'danger':'warning')) ?>">
                                                    <?= ucfirst($item['status']) ?></span></td>
                                                <td class="text-muted"><?= date('d/m/Y H:i',strtotime($item['created_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Kas Masuk -->
                        <div class="tab-pane fade" id="masuk">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead><tr><th>#</th><th>Nominal</th><th>Keterangan</th><th>Tanggal</th></tr></thead>
                                    <tbody>
                                        <?php if (empty($kas_masuk)): ?>
                                            <tr><td colspan="4" class="empty-state"><i class="bi bi-inbox"></i><p>Tidak ada data kas masuk</p></td></tr>
                                        <?php else: foreach ($kas_masuk as $i=>$item): ?>
                                            <tr>
                                                <td class="fw-bold"><?= $i+1 ?></td>
                                                <td class="fw-bold amount-positive">Rp <?= number_format($item['nominal'],0,',','.') ?></td>
                                                <td><?= $item['keterangan'] ?></td>
                                                <td class="text-muted"><?= date('d/m/Y H:i',strtotime($item['created_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Kas Keluar -->
                        <div class="tab-pane fade" id="keluar">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead><tr><th>#</th><th>User</th><th>Nominal</th><th>Keterangan</th><th>Tanggal</th></tr></thead>
                                    <tbody>
                                        <?php if (empty($kas_keluar)): ?>
                                            <tr><td colspan="5" class="empty-state"><i class="bi bi-inbox"></i><p>Tidak ada data kas keluar</p></td></tr>
                                        <?php else: foreach ($kas_keluar as $i=>$item): ?>
                                            <tr>
                                                <td class="fw-bold"><?= $i+1 ?></td>
                                                <td><div class="d-flex align-items-center"><div class="avatar"><?= substr(($item['username']??'S'),0,1) ?></div><?= $item['username']??'System' ?></div></td>
                                                <td class="fw-bold amount-negative">Rp <?= number_format($item['nominal'],0,',','.') ?></td>
                                                <td><?= $item['pengajuan_keterangan'] ?? $item['keterangan'] ?></td>
                                                <td class="text-muted"><?= date('d/m/Y H:i',strtotime($item['created_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
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
    document.addEventListener('DOMContentLoaded',()=>{
        // Toggle saldo visibility
        const toggle=document.getElementById('toggleSaldo');
        const amount=document.getElementById('saldoAmount');
        const eye=document.getElementById('eyeIcon');
        let visible=true;
        toggle.addEventListener('click',()=>{
            visible=!visible;
            if(visible){amount.textContent="Rp <?= number_format($saldo['saldo_akhir'] ?? 0,0,',','.') ?>";eye.className="bi bi-eye";}
            else{amount.textContent="Rp ••••••••";eye.className="bi bi-eye-slash";}
        });

        // Monthly Chart
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

        // Pengajuan Chart
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
    });
</script>

<!-- STYLE -->
<style>
:root {
    --primary:#1a73e8;--primary-dark:#0d47a1;--bg:#121212;--card:#1e1e1e;
    --text:#fff;--text-muted:#b0b0b0;--success:#4caf50;--danger:#f44336;
}
body{background:linear-gradient(135deg,var(--bg),#1a1a2e);color:var(--text);}
.card{background:var(--card);border-radius:16px;transition:.3s;}
.card:hover{transform:translateY(-2px);}
.header-gradient{background:linear-gradient(135deg,var(--primary-dark),var(--primary));padding:20px;border-radius:16px;color:#fff;}

/* Filter */
.filter-card{background-color:rgba(26,26,26,0.6);border:1px solid rgba(255,255,255,0.2);border-radius:10px;padding:6px 10px;transition:all 0.3s ease;}
.filter-card:hover{background-color:rgba(26,26,26,0.8);box-shadow:0 4px 12px rgba(255,255,255,0.15);}
.stylish-select{border-radius:8px;padding:4px 10px;font-size:0.9rem;background-color:rgba(26,26,26,0.7);border:1px solid rgba(255,255,255,0.2);color:#fff;}
.stylish-select:focus{border-color:rgba(255,255,255,0.5);box-shadow:0 0 0 0.2rem rgba(255,255,255,0.2);}

/* Saldo */
.saldo-card{background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;}
.saldo-amount{font-size:2.2rem;font-weight:700;}
.saldo-info-icon{width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;margin:0 auto 6px;}

/* Dashboard Card */
.dashboard-card{background:rgba(26,26,26,0.9);border-radius:14px;box-shadow:0 8px 30px rgba(0,0,0,0.6);border:1px solid rgba(255,255,255,0.1);}
.bg-steam-dark{background-color:rgba(42,71,94,0.5);}
.border-steam{border-color:rgba(102,192,244,0.2)!important;}
.btn-outline-steam{color:#66c0f4;border-color:rgba(102,192,244,0.3);}
.btn-outline-steam:hover,.btn-outline-steam.active{background-color:rgba(102,192,244,0.15);color:white;border-color:rgba(102,192,244,0.5);}
.text-steam-blue{color:#66c0f4;}
.stylish-btn{border-radius:10px;padding:10px 20px;transition:all 0.3s ease;border:1px solid rgba(255,255,255,0.3);}
.stylish-btn:hover{transform:translateY(-2px);box-shadow:0 4px 12px rgba(67,97,238,0.3);}

/* Table */
.table{color:#fff;}
.table th{background:var(--primary-dark);color:#fff;}
.table td{border-bottom:1px solid rgba(255,255,255,.1);}
.amount-positive{color:var(--success);}
.amount-negative{color:var(--danger);}
.avatar{width:32px;height:32px;border-radius:50%;background:var(--primary);color:#fff;display:flex;align-items:center;justify-content:center;margin-right:8px;font-weight:600;}
.status-badge{padding:4px 10px;border-radius:12px;font-size:.8rem;}
.empty-state{text-align:center;padding:30px;color:var(--text-muted);}
.empty-state i{font-size:2rem;opacity:.5;margin-bottom:6px;}

/* Tabs */
.nav-tabs .nav-link{color:var(--text-muted);border:none;}
.nav-tabs .nav-link.active{color:var(--primary);font-weight:600;border-bottom:3px solid var(--primary);}

/* Chart */
#earningCenterText{font-size:1.5rem;font-weight:bold;color:#66c0f4;}
#earningCenterText small{font-size:0.8rem;color:#c7d5e0;}
</style>

<?= $this->endSection() ?>