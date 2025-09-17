<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah User Baru</h1>
</div>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/users/store') ?>">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <!-- role dihapus karena default user -->
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
