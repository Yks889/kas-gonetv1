<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h1>Edit Kas Keluar</h1>

    <form action="<?= base_url('admin/kas_keluar/update/' . $pengajuan['id']) ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="number" name="nominal" id="nominal" value="<?= old('nominal', $pengajuan['nominal']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" required><?= old('keterangan', $pengajuan['keterangan']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" name="deadline" id="deadline" value="<?= old('deadline', $pengajuan['deadline']) ?>" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('admin/kas_keluar') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?= $this->endSection() ?>
