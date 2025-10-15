<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom border-secondary">
        <h1 class="h3 mb-0 text-white">
            <i class="bi bi-plus-circle me-2"></i> Form Pengajuan Kas
        </h1>
        <a href="<?= site_url('user/pengajuan') ?>" class="btn btn-sm btn-outline-light stylish-btn">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Data Pengajuan
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
        <form method="post" action="<?= site_url('user/pengajuan/store') ?>" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row g-3">
                <!-- Tipe Pengajuan -->
                <div class="col-md-6">
                    <label for="tipe" class="form-label text-white">
                        <i class="bi bi-tag me-1"></i> Tipe Pengajuan
                    </label>
                    <select class="form-select modern-input" id="tipe" name="tipe" required>
                        <option value="uang_sendiri">Pakai Uang Sendiri (Reimburse)</option>
                        <option value="minta_uang">Minta Uang ke Admin</option>
                    </select>
                    <div class="form-text text-light">Pilih jenis pengajuan yang sesuai dengan kebutuhan Anda</div>
                </div>

                <!-- Nominal Input -->
                <div class="col-md-6">
                    <label for="nominal" class="form-label text-white">
                        <i class="bi bi-currency-dollar me-1"></i> Nominal (Rp)
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text"
                            class="form-control modern-input <?= (isset($validation) && $validation->hasError('nominal')) ? 'is-invalid' : '' ?>"
                            id="nominal"
                            name="nominal"
                            placeholder="Masukkan nominal pengajuan"
                            required>
                        <div class="invalid-feedback">
                            <?= isset($validation) ? $validation->getError('nominal') : 'Nominal harus diisi dengan angka yang valid' ?>
                        </div>
                    </div>
                    <div class="form-text text-light">Masukkan nominal maksimal Rp 5.000.000.000</div>
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
                        placeholder="Masukkan keterangan pengajuan (contoh: Pembelian alat tulis, Biaya transportasi, dll.)"
                        required></textarea>
                    <div class="invalid-feedback">
                        <?= isset($validation) ? $validation->getError('keterangan') : 'Keterangan harus diisi' ?>
                    </div>
                    <div class="form-text text-light">Jelaskan secara detail alasan dan tujuan pengajuan kas</div>
                </div>

                <!-- Deadline Input -->
                <div class="col-md-6">
                    <label for="deadline" class="form-label text-white">
                        <i class="bi bi-calendar me-1"></i> Tanggal
                    </label>
                    <input type="date"
                        class="form-control modern-input"
                        id="deadline"
                        name="deadline">
                    <div class="form-text text-light">Tentukan tanggal</div>
                </div>

                <!-- Field Upload Nota (hanya tampil jika uang_sendiri) -->
                <div class="col-md-6" id="uploadNotaField" style="display: none;">
                    <label for="file_nota" class="form-label text-white">
                        <i class="bi bi-paperclip me-1"></i> Upload Nota/Struk
                    </label>

                    <!-- Custom File Input -->
                    <div class="custom-file-container">
                        <input type="file"
                            class="custom-file-input"
                            id="file_nota"
                            name="file_nota"
                            accept=".jpg,.jpeg,.png,.pdf">
                        <label for="file_nota" class="custom-file-label">
                            <i class="bi bi-cloud-upload me-2"></i>
                            <span class="file-text">Pilih file...</span>
                        </label>
                    </div>

                    <div class="form-text text-light">Format yang didukung: JPG, PNG, PDF (maks. 5MB)</div>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 mt-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= site_url('user/pengajuan') ?>" class="btn btn-outline-light stylish-btn">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="bi bi-check-circle me-1"></i> Ajukan Kas
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

    .form-control.modern-input:focus,
    .form-select.modern-input:focus {
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

    /* Custom File Input Styling */
    .custom-file-container {
        position: relative;
        width: 100%;
    }

    .custom-file-input {
        position: absolute;
        left: -9999px;
        opacity: 0;
    }

    .custom-file-label {
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #fff;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        min-height: 50px;
        width: 100%;
    }

    .custom-file-label:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }

    .custom-file-label:active {
        transform: translateY(0);
    }

    .file-text {
        color: #bbb;
        font-style: italic;
    }

    /* Style untuk ketika file dipilih */
    .custom-file-input:focus+.custom-file-label {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.8);
    }

    .custom-file-input:valid+.custom-file-label {
        border-color: #06d6a0;
        background: rgba(6, 214, 160, 0.05);
    }

    .custom-file-input:valid+.custom-file-label .file-text {
        color: #06d6a0;
        font-weight: 500;
    }

    /* File name display */
    .custom-file-input:valid+.custom-file-label::after {
        content: attr(data-file-name);
        color: #06d6a0;
        font-weight: 500;
    }

    .custom-file-input:valid+.custom-file-label .file-text {
        display: none;
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

    // Script untuk toggle field upload nota
    document.addEventListener('DOMContentLoaded', function() {
        const tipeSelect = document.getElementById('tipe');
        const uploadNotaField = document.getElementById('uploadNotaField');
        const fileInput = document.getElementById('file_nota');
        const fileLabel = document.querySelector('.custom-file-label');

        function toggleNotaField() {
            if (tipeSelect.value === 'uang_sendiri') {
                uploadNotaField.style.display = 'block';
                fileInput.setAttribute('required', 'required');
            } else {
                uploadNotaField.style.display = 'none';
                fileInput.removeAttribute('required');
                fileInput.value = '';
                // Reset file label
                fileLabel.querySelector('.file-text').textContent = 'Pilih file...';
                fileLabel.removeAttribute('data-file-name');
            }
        }

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file...';
            fileLabel.setAttribute('data-file-name', fileName);
            fileLabel.querySelector('.file-text').textContent = fileName;
        });

        tipeSelect.addEventListener('change', toggleNotaField);
        toggleNotaField(); // panggil sekali saat load
    });

    // Form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<?= $this->endSection() ?>