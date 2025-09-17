<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Form Pengajuan Kas</h4>
            </div>
            <div class="card-body">
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('user/pengajuan/store') ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Pengajuan</label>
                        <select class="form-select" id="tipe" name="tipe" required>
                            <option value="uang_sendiri">Pakai Uang Sendiri (Reimburse)</option>
                            <option value="minta_uang">Minta Uang ke Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline (Opsional)</label>
                        <input type="date" class="form-control" id="deadline" name="deadline">
                    </div>

                    <!-- Field Upload Nota (hanya tampil jika uang_sendiri) -->
                    <div class="mb-3" id="uploadNotaField" style="display: none;">
                        <label for="file_nota" class="form-label">Upload Nota/Struk</label>
                        <input type="file" class="form-control" id="file_nota" name="file_nota" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <button type="submit" class="btn btn-primary">Ajukan</button>
                    <a href="<?= site_url('user/pengajuan') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk toggle field upload nota -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipeSelect = document.getElementById('tipe');
        const uploadNotaField = document.getElementById('uploadNotaField');
        const fileInput = document.getElementById('file_nota');

        function toggleNotaField() {
            if (tipeSelect.value === 'uang_sendiri') {
                uploadNotaField.style.display = 'block';
                fileInput.setAttribute('required', 'required');
            } else {
                uploadNotaField.style.display = 'none';
                fileInput.removeAttribute('required');
                fileInput.value = '';
            }
        }

        tipeSelect.addEventListener('change', toggleNotaField);
        toggleNotaField(); // panggil sekali saat load
    });
</script>

<?= $this->endSection() ?>