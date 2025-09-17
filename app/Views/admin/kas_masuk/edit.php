<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1>Edit Kas Masuk</h1>

    <form action="<?= base_url('admin/kas_masuk/update/' . $kas['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="number" name="nominal" id="nominal" value="<?= old('nominal', $kas['nominal']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" required><?= old('keterangan', $kas['keterangan']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= base_url('admin/kas_masuk') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>
<?= $this->endSection() ?>
