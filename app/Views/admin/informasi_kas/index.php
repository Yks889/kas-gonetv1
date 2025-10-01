<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="header-gradient mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2 text-white">
                    <i class="bi bi-cash-coin me-2"></i>Informasi Kas
                </h1>
                <p class="mb-0 text-light">Ringkasan lengkap pengelolaan kas sistem GoNet</p>
            </div>
            <a href="<?= site_url('admin/dashboard') ?>" class="back-btn">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Saldo Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card saldo-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="mb-1 text-light opacity-75">Saldo Tersedia</h6>
                            <h2 class="saldo-amount" id="saldoAmount">
                                Rp <?= number_format($saldo_akhir, 0, ',', '.') ?>
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
                                <p class="fw-bold mb-0">Rp <?= number_format($total_masuk, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="saldo-info">
                                <div class="saldo-info-icon bg-danger"><i class="bi bi-arrow-up"></i></div>
                                <small>Pengeluaran</small>
                                <p class="fw-bold mb-0">Rp <?= number_format($total_keluar, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="saldo-info">
                                <div class="saldo-info-icon bg-info"><i class="bi bi-list-check"></i></div>
                                <small>Total Transaksi</small>
                                <p class="fw-bold mb-0"><?= count($pengajuan) + count($kas_masuk) + count($kas_keluar) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card quick-actions-card">
                <div class="card-body">
                    <h6 class="mb-3">Aksi Cepat</h6>
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-item">
                                <div class="quick-action-icon bg-primary"><i class="bi bi-plus-circle"></i></div>
                                <span>Kas Masuk</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-item">
                                <div class="quick-action-icon bg-danger"><i class="bi bi-dash-circle"></i></div>
                                <span>Kas Keluar</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-item">
                                <div class="quick-action-icon bg-warning"><i class="bi bi-clipboard-check"></i></div>
                                <span>Pengajuan</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <a href="#" class="quick-action-item">
                                <div class="quick-action-icon bg-info"><i class="bi bi-graph-up"></i></div>
                                <span>Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
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
.back-btn{background:linear-gradient(135deg,var(--primary-dark),var(--primary));border:none;padding:10px 18px;border-radius:10px;color:#fff;text-decoration:none;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(0,0,0,.4);}
.back-btn:hover{opacity:.9;}
/* Saldo */
.saldo-card{background:linear-gradient(135deg,#1a237e,#3949ab);color:#fff;}
.saldo-amount{font-size:2.2rem;font-weight:700;}
.saldo-info-icon{width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;margin:0 auto 6px;}
/* Quick Actions */
.quick-action-item{display:flex;flex-direction:column;align-items:center;padding:15px;border-radius:12px;color:#fff;text-decoration:none;transition:.3s;}
.quick-action-item:hover{background:rgba(255,255,255,.05);}
.quick-action-icon{width:55px;height:55px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff;margin-bottom:6px;}
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
</style>

<!-- SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded',()=>{
    const toggle=document.getElementById('toggleSaldo');
    const amount=document.getElementById('saldoAmount');
    const eye=document.getElementById('eyeIcon');
    let visible=true;
    toggle.addEventListener('click',()=>{
        visible=!visible;
        if(visible){amount.textContent="Rp <?= number_format($saldo_akhir,0,',','.') ?>";eye.className="bi bi-eye";}
        else{amount.textContent="Rp ••••••••";eye.className="bi bi-eye-slash";}
    });
});
</script>

<?= $this->endSection() ?>
