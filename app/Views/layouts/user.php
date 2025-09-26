<?php if (session()->get('role') === 'user'): ?>
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

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                z-index: 1000;
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
                padding: 80px 25px 25px 25px;
                min-height: 100vh;
                background-color: #0f0f0f;
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

            /* Card Styles */
            .dashboard-card {
                background: #1a1a1a;
                border: 1px solid #2c2c2c;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                transition: all 0.3s ease;
            }

            .dashboard-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            }

            /* Table Styles */
            .table-container {
                background: #1a1a1a;
                border-radius: 8px;
                overflow: hidden;
                border: 1px solid #2c2c2c;
            }

            .table {
                color: #e0e0e0;
                margin-bottom: 0;
            }

            .table th {
                background: #2c2c2c;
                color: #fff;
                border-bottom: 1px solid #3c3c3c;
                padding: 12px 15px;
            }

            .table td {
                padding: 12px 15px;
                border-bottom: 1px solid #2c2c2c;
            }

            .table tr:hover {
                background: #1f1f1f;
            }

            /* Form Styles */
            .form-control {
                background: #1a1a1a;
                border: 1px solid #2c2c2c;
                color: #e0e0e0;
            }

            .form-control:focus {
                background: #1a1a1a;
                border-color: #4da3ff;
                color: #e0e0e0;
                box-shadow: 0 0 0 0.2rem rgba(77, 163, 255, 0.25);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .sidebar {
                    width: 100%;
                    left: -100%;
                }

                .sidebar.mobile-show {
                    left: 0;
                }

                .main-header {
                    left: 0;
                }

                .main-content {
                    margin-left: 0;
                    padding-top: 60px;
                }
            }

            /* Mobile menu button */
            .mobile-menu-btn {
                display: none;
                background: none;
                border: none;
                color: #fff;
                font-size: 1.5rem;
            }

            @media (max-width: 768px) {
                .mobile-menu-btn {
                    display: block;
                }
            }
        </style>
    </head>

    <body>
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn position-fixed" style="top: 15px; left: 15px; z-index: 1001;">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo" style="height: 40px; width: auto;">
                <span>Kas - GoNet</span>
            </div>

            <ul class="nav flex-column">
                 <li>
                    <div class="sidebar-divider"></div>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'dashboard' ? 'active' : '' ?>"
                        href="<?= site_url('user/dashboard') ?>"><i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span></a></li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'pengajuan' ? 'active' : '' ?>"
                        href="<?= site_url('user/pengajuan/index') ?>"><i class="bi bi-pencil-square"></i> <span>Pengajuan
                            Kas</span></a></li>
            </ul>
            <div class="bottom-logout">
                <a class="nav-link text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right"></i>
                    Logout</a>
            </div>
        </div>
      
        <!-- Main Content -->
        <main class="main-content">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            // Mobile sidebar toggle
            document.querySelector('.mobile-menu-btn').addEventListener('click', function () {
                document.querySelector('.sidebar').classList.toggle('mobile-show');
            });

            // Initialize DataTables if table exists
            document.addEventListener('DOMContentLoaded', function () {
                if (document.querySelector('.data-table')) {
                    $('.data-table').DataTable({
                        language: {
                            search: "Cari:",
                            lengthMenu: "Tampilkan _MENU_ data per halaman",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                            paginate: {
                                first: "Pertama",
                                last: "Terakhir",
                                next: "Selanjutnya",
                                previous: "Sebelumnya"
                            }
                        },
                        responsive: true
                    });
                }

                // Auto-hide alerts after 5 seconds
                setTimeout(function () {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(function (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (event) {
                const sidebar = document.querySelector('.sidebar');
                const menuBtn = document.querySelector('.mobile-menu-btn');

                if (window.innerWidth <= 768 &&
                    !sidebar.contains(event.target) &&
                    !menuBtn.contains(event.target) &&
                    sidebar.classList.contains('mobile-show')) {
                    sidebar.classList.remove('mobile-show');
                }
            });
        </script>

        <?= $this->renderSection('scripts') ?>
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