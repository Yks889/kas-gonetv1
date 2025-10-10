<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h1 class="h3 mb-0 text-white">
            <i class="bi bi-pencil-square me-2"></i> Edit User
        </h1>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-sm btn-outline-light stylish-btn">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if (isset($validation)): ?>
        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
    <?php endif; ?>

    <div class="dashboard-card p-4">
        <form method="post" action="<?= site_url('admin/users/update/' . $user['id']) ?>">
            <div class="mb-3">
                <label for="username" class="form-label text-white">Username</label>
                <input type="text" class="form-control modern-input" id="username" name="username"
                    value="<?= esc($user['username']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-white">Password <small class="text-light">(Kosongkan jika tidak diubah)</small></label>
                <input type="password" class="form-control modern-input" id="password" name="password">
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-gradient-primary">
                    <i class="bi bi-save me-1"></i> Update
                </button>
                <a href="<?= site_url('admin/users') ?>" class="btn btn-outline-light stylish-btn">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Styling -->
<style>
    .dashboard-card {
        background: rgba(26, 26, 26, 0.9);
        border-radius: 14px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
    }

    .modern-input {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .modern-input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 10px rgba(67, 97, 238, 0.6);
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #4cc9f0);
        border: none;
        border-radius: 8px;
        color: #fff;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .btn-gradient-primary:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .stylish-btn {
        border-radius: 10px;
        padding: 6px 14px;
        transition: 0.3s;
    }

    .stylish-btn:hover {
        background: #4361ee;
        border-color: #4361ee;
        color: #fff;
        box-shadow: 0 0 8px rgba(67, 97, 238, 0.8);
    }
</style>

<?= $this->endSection() ?>