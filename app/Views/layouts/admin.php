<?php if (session()->get('role') === 'admin'): ?>
    <!DOCTYPE html>
    <html lang="id" data-theme="dark">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?? 'Sistem Kas - GoNet' ?></title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            body {
                font-family: 'Montserrat', sans-serif;
                background-color: #0f0f0f;
                color: #e0e0e0;
                margin: 0;
            }

            /* Sidebar */
            .sidebar {
                width: 260px;
                background: #141414;
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                padding: 20px 0;
                border-right: 1px solid #2c2c2c;
                display: flex;
                flex-direction: column;
                transition: all 0.3s ease;
            }

            .sidebar .logo {
                font-size: 1.3rem;
                font-weight: 600;
                padding: 0 20px;
                margin-bottom: 30px;
                color: #fff;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .sidebar-divider {
                height: 2px;
                background-color: #2c2c2c;
                margin: 10px 20px;
            }

            .sidebar .nav-link {
                color: #aaa;
                padding: 12px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 0.95rem;
                transition: all 0.2s;
                border-radius: 8px;
                margin: 3px 10px;
            }

            .sidebar .nav-link i {
                font-size: 1.2rem;
                color: #888;
            }

            .sidebar .nav-link.active,
            .sidebar .nav-link:hover {
                background: #1f1f1f;
                color: #fff;
            }

            .sidebar .nav-link.active i,
            .sidebar .nav-link:hover i {
                color: #4da3ff;
            }

            .sidebar .bottom-logout {
                margin-top: auto;
                padding: 0 20px;
            }

            /* Header */
            .main-header {
                position: fixed;
                top: 0;
                left: 260px;
                right: 0;
                height: 60px;
                background: #141414;
                border-bottom: 1px solid #2c2c2c;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 20px;
                z-index: 100;
            }

            .main-header .title {
                font-size: 1.2rem;
                font-weight: 600;
                color: #fff;
            }

            /* Content */
            .main-content {
                margin-left: 260px;
                /* karena ada sidebar */
                padding: 25px;
                /* tanpa space atas berlebih */
            }

            /* Dropdown */
            .dropdown-menu {
                background: #1f1f1f;
                border: 1px solid #2c2c2c;
            }

            .dropdown-item {
                color: #e0e0e0;
            }

            .dropdown-item:hover {
                background: #2c2c2c;
                color: #fff;
            }
        </style>
    </head>

    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo" style="height: 40px; width: auto;">
                <span>Kas - GoNet</span>
            </div>

            <ul class="nav flex-column">
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('admin/dashboard') ?>"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'users' ? 'active' : '' ?>" href="<?= site_url('admin/users') ?>"><i class="bi bi-person-badge"></i> <span>Manajemen User</span></a></li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'laporan' ? 'active' : '' ?>" href="<?= site_url('admin/laporan') ?>"><i class="bi bi-journal-text"></i> <span>Aktivitas User</span></a></li>
                 <li>
                    <div class="sidebar-divider"></div>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'kas_masuk' ? 'active' : '' ?>" href="<?= site_url('admin/kas_masuk') ?>"><i class="bi bi-cash-coin"></i> <span>Kas Masuk</span></a></li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'kas_keluar' ? 'active' : '' ?>" href="<?= site_url('admin/kas_keluar') ?>"><i class="bi bi-cash-stack"></i> <span>Kas Keluar</span></a></li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'pengajuan' ? 'active' : '' ?>" href="<?= site_url('admin/pengajuan') ?>"><i class="bi bi-clipboard-check"></i> <span>Pengajuan</span></a></li>
            </ul>
            <div class="bottom-logout">
                <a class="nav-link text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php else: ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Akses Ditolak - Sistem Kas GoNet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #1b2838, #2a475e);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Montserrat', sans-serif;
            }

            .access-denied {
                background: linear-gradient(to bottom, #2a475e, #1b2838);
                padding: 3rem;
                border-radius: 4px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                text-align: center;
                max-width: 500px;
                border: 1px solid rgba(102, 192, 244, 0.2);
                color: #c7d5e0;
            }

            .access-denied i {
                font-size: 5rem;
                color: #d33c40;
                margin-bottom: 1.5rem;
            }

            .access-denied h1 {
                color: #66c0f4;
            }

            .btn-primary {
                background: linear-gradient(to bottom, #67c1f5, #417a9b);
                border: none;
                border-radius: 2px;
                padding: 8px 16px;
                font-weight: 500;
                color: #fff;
                text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.33);
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            }
        </style>
    </head>

    <body>
        <div class="access-denied">
            <i class="bi bi-shield-exclamation"></i>
            <h1 class="text-danger">Akses Ditolak</h1>
            <p class="lead">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <a href="<?= site_url('login') ?>" class="btn btn-primary mt-3">Kembali ke Login</a>
        </div>
    </body>

    </html>
<?php endif; ?>