<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Kas Masuk</h1>
    <a href="<?= site_url('admin/kas_masuk/create') ?>" class="btn btn-primary">Tambah Kas Masuk</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kas_masuk as $kas): ?>
                <tr>
                    <td><?= $kas['id'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($kas['created_at'])) ?></td>
                    <td>Rp <?= number_format($kas['nominal'], 0, ',', '.') ?></td>
                    <td><?= $kas['keterangan'] ?></td>
                    <td>
                        <a href="<?= site_url('admin/kas_masuk/edit/' . $kas['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('admin/kas_masuk/delete/' . $kas['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>