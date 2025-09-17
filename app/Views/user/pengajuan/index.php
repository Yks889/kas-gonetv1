<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>History Pengajuan</h2>
            <a href="<?= site_url('user/pengajuan/create') ?>" class="btn btn-primary">+ Tambah</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Tipe</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pengajuan)): ?>
                        <?php foreach ($pengajuan as $p): ?>
                            <tr>
                                <td><?= $p['id'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                                <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                                <td><?= $p['keterangan'] ?></td>
                                <td>
                                    <?= $p['tipe'] == 'uang_sendiri'
                                        ? '<span class="badge bg-info">Uang Sendiri</span>'
                                        : '<span class="badge bg-primary">Minta Uang</span>' ?>
                                </td>
                                <td><?= $p['deadline'] ? date('d/m/Y', strtotime($p['deadline'])) : '-' ?></td>
                                <td>
                                    <span class="badge bg-<?=
                                                            $p['status'] == 'diterima' ? 'success' : ($p['status'] == 'ditolak' ? 'danger' : ($p['status'] == 'selesai' ? 'warning' : 'secondary'))
                                                            ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada pengajuan kas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>