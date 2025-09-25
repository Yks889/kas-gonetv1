<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-secondary">
        <h1 class="h3 mb-0 text-white">
            <i class="bi bi-plus-circle me-2"></i> Tambah Kas Masuk
        </h1>
        <a href="<?= site_url('admin/kas_masuk') ?>" class="btn btn-sm btn-outline-light stylish-btn">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Kas
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> Terdapat kesalahan dalam pengisian form:
            <ul class="mb-0 mt-1">
                <?php foreach ($validation->getErrors() as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="dashboard-card p-4">
        <form method="post" action="<?= site_url('admin/kas_masuk/store') ?>" class="needs-validation" novalidate>
            <div class="row g-3">
                <!-- Nominal Input -->
                <div class="col-md-6">
                    <label for="nominal" class="form-label text-white">
                        <i class="bi bi-currency-dollar me-1"></i> Nominal
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text"
                            class="form-control modern-input <?= (isset($validation) && $validation->hasError('nominal')) ? 'is-invalid' : '' ?>"
                            id="nominal"
                            name="nominal"
                            placeholder="Masukkan nominal kas masuk"
                            value="<?= old('nominal') ?>"
                            required>
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('nominal') : 'Nominal harus diisi dengan angka yang valid' ?>
                        </div>
                    </div>
                    <div class="form-text text-light">Masukkan nominal maksimal Rp 5.000.000.000</div>
                </div>

                <!-- Tanggal Input -->
                <div class="col-md-6">
                    <label for="tanggal" class="form-label text-white">
                        <i class="bi bi-calendar me-1"></i> Tanggal Transaksi
                    </label>
                    <input type="datetime-local"
                        class="form-control modern-input"
                        id="tanggal"
                        name="tanggal"
                        value="<?= old('tanggal', date('Y-m-d\TH:i')) ?>">
                    <div class="form-text text-light">Kosongkan untuk menggunakan tanggal saat ini</div>
                </div>

                <!-- Keterangan Input -->
                <div class="col-12">
                    <label for="keterangan" class="form-label text-white">
                        <i class="bi bi-card-text me-1"></i> Keterangan
                    </label>
                    <textarea class="form-control modern-input <?= (isset($validation) && $validation->hasError('keterangan')) ? 'is-invalid' : '' ?>"
                        id="keterangan"
                        name="keterangan"
                        rows="4"
                        placeholder="Masukkan keterangan kas masuk (contoh: Setoran modal, Penjualan produk, dll.)"
                        required><?= old('keterangan') ?></textarea>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('keterangan') : 'Keterangan harus diisi' ?>
                    </div>
                    <div class="form-text text-light">Jelaskan sumber atau alasan kas masuk</div>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 mt-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= site_url('admin/kas_masuk') ?>" class="btn btn-outline-light stylish-btn">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="bi bi-check-circle me-1"></i> Simpan Kas Masuk
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Styling tambahan -->
<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .modern-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 12px;
        transition: all 0.3s ease;
        padding: 12px 16px;
    }

    .form-control.modern-input:focus {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.3) !important;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.8) !important;
        color: #fff !important;
    }

    .modern-input::placeholder {
        color: #bbb;
        font-style: italic;
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 500;
        padding: 10px 24px;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stylish-btn:hover {
        background: #4361ee;
        border-color: #4361ee;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .input-group-text {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #fff !important;
    }
</style>

<!-- Script Format Nominal -->
<script>
    const nominalInput = document.getElementById('nominal');
    const form = document.querySelector('form');

    // Format saat input
    nominalInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.dataset.raw = value; // simpan angka murni
        e.target.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
    });

    // Saat submit, kirim angka murni
    form.addEventListener('submit', function() {
        nominalInput.value = nominalInput.dataset.raw || '';
    });
</script>

<?= $this->endSection() ?>