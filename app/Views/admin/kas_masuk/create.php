<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Kas Masuk</h1>
</div>

<?php if (isset($validation)): ?>
    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('admin/kas_masuk/store') ?>">
    <div class="mb-3">
        <label for="nominal" class="form-label">Nominal</label>
        <input type="number" class="form-control" id="nominal" name="nominal" required>
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= site_url('admin/kas_masuk') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>