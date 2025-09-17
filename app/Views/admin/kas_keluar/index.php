<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kas Keluar</h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengajuan as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['username'] ?></td>
                    <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                    <td><?= $p['keterangan'] ?></td>
                    <td><?= $p['deadline'] ? date('d/m/Y', strtotime($p['deadline'])) : '-' ?></td>
                    <td>
                        <span class="badge bg-<?=
                            $p['status'] == 'diterima' ? 'success' : ($p['status'] == 'ditolak' ? 'danger' : ($p['status'] == 'diproses' ? 'warning' : 'secondary'))
                        ?>">
                            <?= ucfirst($p['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= site_url('admin/kas_keluar/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="<?= site_url('admin/kas_keluar/delete/' . $p['id']) ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin mau hapus data ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
