<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4">Dashboard Admin</h1>

            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Saldo Kas</h5>
                            <h3 class="card-text">Rp <?= number_format($saldo['saldo_akhir'] ?? 0, 0, ',', '.') ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pemasukan</h5>
                            <h3 class="card-text">Rp <?= number_format($total_masuk['total'] ?? 0, 0, ',', '.') ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengeluaran</h5>
                            <h3 class="card-text">Rp <?= number_format($total_keluar['total'] ?? 0, 0, ',', '.') ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pengajuan Pending</h5>
                            <h3 class="card-text"><?= $pengajuan_pending ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Statistik Pengguna</h5>
                        </div>
                        <div class="card-body">
                            <p>Total User: <?= $total_users ?></p>
                            <p>Total Pengajuan: <?= $total_pengajuan ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= site_url('admin/kas_masuk/create') ?>" class="btn btn-primary me-2">Tambah Kas Masuk</a>
                            <a href="<?= site_url('admin/pengajuan') ?>" class="btn btn-warning">Lihat Pengajuan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>