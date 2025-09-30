<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<link rel="icon" href="<?= base_url('uploads/logo.png') ?>" type="image/png" />
<?php $validation = session('validation') ?? \Config\Services::validation(); ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-5 border-bottom border-secondary">
        <h1 class="h3 mb-1 text-white">
            <i class="bi bi-person-gear me-2"></i> Profil Pengguna
        </h1>
    </div>

    <?php if (session()->get('message')): ?>
        <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div><?= session()->get('message') ?></div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->get('error')): ?>
        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div><?= session()->get('error') ?></div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Profil Card -->
    <div class="dashboard-card p-4">
        <div class="row">
            <!-- Kolom Kiri - Foto Profil -->
            <div class="col-md-4 text-center">
                <div class="profile-section mb-4">
                    <?php if (isset($user['photo']) && !empty($user['photo'])): ?>
                        <img src="<?= base_url('uploads/profiles/' . $user['photo']) ?>"
                            class="rounded-circle mb-3 profile-image" width="150" height="150" alt="Foto Profil">
                    <?php else: ?>
                        <div
                            class="profile-placeholder rounded-circle d-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-person" style="font-size: 4rem;"></i>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/profile/update-photo" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="photo" class="form-label text-white">Unggah Foto Baru</label>
                            <input
                                class="form-control modern-input <?= $validation->hasError('photo') ? 'is-invalid' : '' ?>"
                                type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg">
                            <div class="invalid-feedback">
                                <?= $validation->getError('photo') ?>
                            </div>
                            <small class="form-text text-muted">Format: JPG/PNG, maks 2MB</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="bi bi-upload me-1"></i> Unggah Foto
                            </button>

                            <?php if (isset($user['photo']) && !empty($user['photo'])): ?>
                                <button type="button" class="btn btn-outline-danger stylish-btn"
                                    onclick="confirmRemovePhoto()">
                                    <i class="bi bi-trash me-1"></i> Hapus Foto
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>

                    <?php if (isset($user['photo']) && !empty($user['photo'])): ?>
                        <form id="removePhotoForm" action="/admin/profile/remove-photo" method="post" class="d-none">
                            <?= csrf_field() ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Kolom Kanan - Form Data -->
            <div class="col-md-8">
                <!-- Informasi Profil -->
                <div class="profile-section mb-4">
                    <h5 class="section-title mb-4">
                        <i class="bi bi-person-lines-fill me-2"></i>Informasi Profil
                    </h5>

                    <form action="/admin/profile/update" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-17">
                                <label for="username" class="form-label text-white">Username</label>
                                <input type="text"
                                    class="form-control modern-input <?= $validation->hasError('username') ? 'is-invalid' : '' ?>"
                                    id="username" name="username"
                                    value="<?= old('username', $user['username'] ?? '') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username') ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-gradient-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>

                <div class="section-divider my-4"></div>

                <!-- Ubah Password -->
                <div class="profile-section">
                    <h5 class="section-title mb-4">
                        <i class="bi bi-shield-lock me-2"></i>Ubah Password
                    </h5>

                    <form action="/admin/profile/update-password" method="post">
                        <?= csrf_field() ?>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="current_password" class="form-label text-white">Password Saat Ini</label>
                                <input type="password"
                                    class="form-control modern-input <?= $validation->hasError('current_password') ? 'is-invalid' : '' ?>"
                                    id="current_password" name="current_password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('current_password') ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="new_password" class="form-label text-white">Password Baru</label>
                                <input type="password"
                                    class="form-control modern-input <?= $validation->hasError('new_password') ? 'is-invalid' : '' ?>"
                                    id="new_password" name="new_password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('new_password') ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="confirm_password" class="form-label text-white">Konfirmasi Password</label>
                                <input type="password"
                                    class="form-control modern-input <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>"
                                    id="confirm_password" name="confirm_password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('confirm_password') ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-gradient-primary px-4">
                                <i class="bi bi-key me-1"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        overflow: hidden;
    }

    .profile-section {
        padding: 1.5rem;
    }

    .section-title {
        color: #66c0f4;
        font-weight: 600;
        font-size: 1.1rem;
        border-bottom: 2px solid rgba(67, 97, 238, 0.3);
        padding-bottom: 0.5rem;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(67, 97, 238, 0.5), transparent);
    }

    .profile-image {
        border: 3px solid #4361ee;
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
        transition: transform 0.3s ease;
    }

    .profile-image:hover {
        transform: scale(1.05);
    }

    .profile-placeholder {
        width: 150px;
        height: 150px;
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        margin: 0 auto;
        color: white;
        border: 3px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
    }

    .modern-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 12px;
        transition: all 0.3s ease;
        padding: 10px 15px;
    }

    .modern-input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 10px rgba(67, 97, 238, 0.6);
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .modern-input::placeholder {
        color: #bbb;
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
        background: linear-gradient(45deg, #3a56d4, #45b8e0);
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        border: 1px solid #dc3545;
    }

    .stylish-btn:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #fff;
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.8);
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 10px;
        border: none;
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
        border-left: 4px solid #dc3545;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-text {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .invalid-feedback {
        font-size: 0.85rem;
    }

    /* SweetAlert2 Custom Styling */
    .swal2-popup.profile-modal {
        background: linear-gradient(135deg, rgba(40, 40, 60, 0.98), rgba(30, 30, 50, 0.98));
        border: 1px solid rgba(67, 97, 238, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        color: #fff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(15px);
    }

    .swal2-popup.profile-modal .swal2-title {
        color: #fff;
        font-weight: 600;
    }

    .swal2-popup.profile-modal .swal2-content {
        color: #ccc;
    }
</style>

<script>
    function confirmRemovePhoto() {
        Swal.fire({
            customClass: {
                popup: 'profile-modal'
            },
            title: 'Hapus Foto Profil?',
            text: "Anda yakin ingin menghapus foto profil? Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
            cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            buttonsStyling: true,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('removePhotoForm').submit();
            }
        });
    }

    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function () {
        // Add focus effects to form inputs
        const inputs = document.querySelectorAll('.modern-input');
        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function () {
                this.parentElement.classList.remove('focused');
            });
        });

        // Add loading state to buttons
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function () {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-2"></i>Memproses...';
                    submitBtn.disabled = true;
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>