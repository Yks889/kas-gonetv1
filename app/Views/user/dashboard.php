<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4">Dashboard User</h1>

            <div class="row">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengajuan</h5>
                            <h3 class="card-text"><?= $total_pengajuan ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Diterima</h5>
                            <h3 class="card-text"><?= $pengajuan_diterima ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <h3 class="card-text"><?= $pengajuan_pending ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">Ditolak</h5>
                            <h3 class="card-text"><?= $pengajuan_ditolak ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Aksi Cepat</h5>
                        </div>
                        <div class="card-body">
                            <a href="<?= site_url('user/pengajuan/create') ?>" class="btn btn-primary me-2">Ajukan Kas Baru</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>