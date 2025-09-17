<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User</h1>
</div>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/users/update/' . $user['id']) ?>">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <!-- role dihapus, otomatis user -->
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
    