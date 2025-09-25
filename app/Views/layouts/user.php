<!DOCTYPE html>
<html lang="id" data-theme="light">

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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --steam-dark: #1b2838;
            --steam-blue: #66c0f4;
            --steam-light-blue: #c7d5e0;
            --steam-gray: #2a475e;
            --steam-light-gray: #c7d5e0;
            --steam-green: #5c7e10;
            --steam-header: #171a21;
            --steam-panel: #1e252d;
            --steam-accent: #3d4450;
            --sidebar-width: 240px;
            --sidebar-collapsed-width: 70px;
            --header-height: 60px;
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--steam-dark);
            color: var(--steam-light-blue);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles - Steam Inspired */
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: var(--steam-header);
            height: var(--header-height);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            border-bottom: 1px solid rgba(102, 192, 244, 0.1);
        }

        .brand-logo {
            height: 36px;
            width: auto;
        }

        .brand-name {
            font-weight: 700;
            color: var(--steam-blue);
            font-size: 1.4rem;
        }

        .arsip-surat {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--steam-light-blue);
        }

        /* Sidebar Styles - Steam Inspired */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(to bottom, #1e252d, #171a21);
            height: calc(100vh - var(--header-height));
            position: fixed;
            top: var(--header-height);
            left: 0;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.4);
            transition: var(--transition);
            overflow-y: auto;
            z-index: 999;
            border-right: 1px solid rgba(102, 192, 244, 0.1);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .nav-link {
            color: #b8b6b4;
            padding: 12px 15px;
            margin: 4px 10px;
            border-radius: 3px;
            transition: var(--transition);
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
            transition: var(--transition);
            color: #66c0f4;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(102, 192, 244, 0.1);
            color: #ffffff;
        }

        .sidebar .nav-link:hover i {
            color: #ffffff;
        }

        .sidebar .nav-link.active {
            background-color: rgba(102, 192, 244, 0.2);
            color: #ffffff;
            border-left: 3px solid var(--steam-blue);
        }

        .sidebar .nav-link.active i {
            color: #ffffff;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            padding-top: calc(var(--header-height) + 20px);
            min-height: calc(100vh - var(--header-height));
            transition: var(--transition);
            background-color: var(--steam-dark);
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Card Styles - Steam Inspired */
        .dashboard-card {
            border-radius: 3px;
            border: none;
            background: linear-gradient(to bottom, #2a3f5a, #1e2a38);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            transition: var(--transition);
            color: var(--steam-light-blue);
            border: 1px solid rgba(102, 192, 244, 0.1);
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            background: linear-gradient(to bottom, #2f4b6b, #212e40);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 15px;
            background-color: rgba(102, 192, 244, 0.15);
            color: var(--steam-blue);
        }

        .sidebar .divider {
            border: 0;
            height: 1px;
            width: 85%;
            margin: 12px auto;
            background: linear-gradient(to right, transparent, rgba(102, 192, 244, 0.2), transparent);
        }

        /* Button Styles - Steam Inspired */
        .btn-primary {
            background: linear-gradient(to bottom, #6ba2d1, #4a7ea8);
            border: none;
            border-radius: 2px;
            padding: 8px 16px;
            font-weight: 500;
            color: #d8e8f7;
            text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.33);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(to bottom, #79afe0, #5590c0);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
            color: white;
        }

        /* Table Styles - Steam Inspired */
        .table-container {
            background: linear-gradient(to bottom, #2a3f5a, #1e2a38);
            border-radius: 3px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(102, 192, 244, 0.1);
        }

        .table {
            color: var(--steam-light-blue);
            margin-bottom: 0;
        }

        .table th {
            background-color: rgba(35, 53, 72, 0.9);
            font-weight: 600;
            color: #6ba2d1;
            border-top: none;
            border-bottom: 1px solid rgba(102, 192, 244, 0.15);
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid rgba(102, 192, 244, 0.08);
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table tr:hover {
            background-color: rgba(102, 192, 244, 0.07);
        }

        /* Form Styles */
        .form-control {
            background-color: rgba(35, 53, 72, 0.6);
            border: 1px solid rgba(102, 192, 244, 0.15);
            color: var(--steam-light-blue);
            border-radius: 2px;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background-color: rgba(35, 53, 72, 0.8);
            border-color: #6ba2d1;
            box-shadow: 0 0 0 0.2rem rgba(107, 162, 209, 0.25);
            color: var(--steam-light-blue);
        }

        .form-label {
            color: #6ba2d1;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Badge Styles */
        .badge-success {
            background: linear-gradient(to bottom, #5c7e10, #43590c);
        }

        .badge-warning {
            background: linear-gradient(to bottom, #f2b51c, #b3871a);
        }

        .badge-danger {
            background: linear-gradient(to bottom, #d33c40, #9d2c2f);
        }

        /* Alert Styles */
        .alert {
            border-radius: 2px;
            border: none;
            background: linear-gradient(to bottom, #2a3f5a, #1e2a38);
            border: 1px solid rgba(102, 192, 244, 0.1);
            color: var(--steam-light-blue);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            background-color: #2a3f5a;
            border: 1px solid rgba(102, 192, 244, 0.15);
            border-radius: 2px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        /* Samakan warna Role dengan item dropdown lain */
        .dropdown-item-text {
            color: var(--steam-light-blue) !important;
            font-size: 0.9rem;
            padding: 8px 16px;
            display: block;
            text-align: center;
        }

        .dropdown-item {
            color: var(--steam-light-blue);
            padding: 8px 16px;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: rgba(102, 192, 244, 0.1);
            color: white;
        }

        .dropdown-divider {
            border-color: rgba(102, 192, 244, 0.15);
        }

        /* User dropdown */
        .btn-outline-light {
            border-color: rgba(102, 192, 244, 0.2);
            color: var(--steam-light-blue);
            background-color: rgba(42, 63, 90, 0.4);
        }

        .btn-outline-light:hover {
            background-color: rgba(102, 192, 244, 0.1);
            border-color: rgba(102, 192, 244, 0.3);
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar .nav-link span {
                display: none;
            }

            .sidebar .nav-link i {
                margin-right: 0;
            }

            .main-content {
                margin-left: var(--sidebar-collapsed-width);
            }

            .sidebar.mobile-expanded {
                width: var(--sidebar-width);
            }

            .sidebar.mobile-expanded .nav-link span {
                display: inline;
            }

            .sidebar.mobile-expanded .nav-link i {
                margin-right: 12px;
            }

            .main-content.mobile-expanded {
                margin-left: var(--sidebar-width);
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--steam-light-blue) !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: rgba(35, 53, 72, 0.6);
            border: 1px solid rgba(102, 192, 244, 0.15);
            color: var(--steam-light-blue);
            border-radius: 2px;
            padding: 4px 8px;
        }

        .page-item .page-link {
            background-color: rgba(35, 53, 72, 0.6);
            border: 1px solid rgba(102, 192, 244, 0.15);
            color: var(--steam-light-blue);
        }

        .page-item.active .page-link {
            background: linear-gradient(to bottom, #6ba2d1, #4a7ea8);
            border-color: rgba(102, 192, 244, 0.2);
        }

        /* Chart Container */
        .chart-container {
            background: linear-gradient(to bottom, #2a3f5a, #1e2a38);
            border-radius: 3px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(102, 192, 244, 0.1);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="main-header sticky-top">
        <div class="container-fluid h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
                <div class="d-flex align-items-center">
                    <button class="btn text-white me-3 d-lg-none" id="mobileSidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <a href="/user/dashboard" class="navbar-brand d-flex align-items-center">
                        <img src="/uploads/logo.png" alt="Logo GoNet" class="brand-logo me-2">
                        <span class="arsip-surat">Sistem Kas - <span class="brand-name">Gonet</span></span>
                    </a>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button"
                        id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2"></i>
                        <span><?= session()->get('username') ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><span class="dropdown-item-text"><i
                                    class="bi bi-person-circle me-2"></i><?= ucfirst(session()->get('role')) ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i
                                    class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= service('uri')->getSegment(2) === 'dashboard' ? 'active' : '' ?>"
                        href="<?= site_url('user/dashboard') ?>">
                        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= service('uri')->getSegment(2) === 'pengajuan' ? 'active' : '' ?>"
                        href="<?= site_url('user/pengajuan/index') ?>">
                        <i class="bi bi-pencil-square"></i> <span>Pengajuan Kas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= service('uri')->getSegment(2) === 'riwayat' ? 'active' : '' ?>"
                        href="<?= site_url('user/riwayat') ?>">
                        <i class="bi bi-clock-history"></i> <span>Riwayat Pengajuan</span>
                    </a>
                </li>   
                <li class="nav-item mt-4">
                    <a class="nav-link text-danger" href="<?= site_url('logout') ?>">
                        <i class="bi bi-box-arrow-right me-2 text-danger"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('mobileSidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('mobile-expanded');
            document.getElementById('mainContent').classList.toggle('mobile-expanded');
        });

        // Initialize DataTables if table exists
        document.addEventListener('DOMContentLoaded', function () {
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
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>