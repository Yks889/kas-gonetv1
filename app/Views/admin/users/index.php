<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen User</h1>
    <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary">Tambah User</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td>
                        <span class="badge bg-primary">User</span>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                    <td>
                        <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= site_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
