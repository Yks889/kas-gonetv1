<?php if (session()->get('role') === 'admin') : ?>
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
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <style>
            :root {
                --primary: #4361ee;
                --secondary: #3f37c9;
                --success: #4cc9f0;
                --info: #4895ef;
                --warning: #f72585;
                --danger: #e63946;
                --light: #f8f9fa;
                --dark: #212529;
                --sidebar-width: 280px;
                --sidebar-collapsed-width: 80px;
                --header-height: 70px;
                --transition: all 0.3s ease;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f5f7fb;
                color: #333;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* Header Styles */
            .main-header {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                height: var(--header-height);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }

            .brand-logo {
                height: 40px;
                width: auto;
            }

            .brand-name {
                font-weight: 700;
                color: white;
            }

            .arsip-surat {
                font-size: 1.2rem;
                font-weight: 500;
                color: white;
            }

            /* Sidebar Styles */
            .sidebar {
                width: var(--sidebar-width);
                background: white;
                height: calc(100vh - var(--header-height));
                position: fixed;
                top: var(--header-height);
                left: 0;
                box-shadow: 3px 0 10px rgba(0, 0, 0, 0.05);
                transition: var(--transition);
                overflow-y: auto;
                z-index: 999;
            }

            .sidebar.collapsed {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar .nav-link {
                color: #555;
                padding: 12px 20px;
                margin: 4px 10px;
                border-radius: 8px;
                transition: var(--transition);
                display: flex;
                align-items: center;
            }

            .sidebar .nav-link i {
                margin-right: 12px;
                font-size: 18px;
                width: 24px;
                text-align: center;
                transition: var(--transition);
            }

            .sidebar.collapsed .nav-link span {
                display: none;
            }

            .sidebar.collapsed .nav-link i {
                margin-right: 0;
            }

            .sidebar .nav-link:hover {
                background-color: rgba(67, 97, 238, 0.1);
                color: var(--primary);
            }

            .sidebar .nav-link.active {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                color: white;
                box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
            }

            /* Main Content */
            .main-content {
                margin-left: var(--sidebar-width);
                padding: 20px;
                transition: var(--transition);
                min-height: calc(100vh - var(--header-height));
            }

            .main-content.expanded {
                margin-left: var(--sidebar-collapsed-width);
            }

            /* Card Styles */
            .dashboard-card {
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                transition: var(--transition);
            }

            .dashboard-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            }

            .card-icon {
                width: 60px;
                height: 60px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                margin-bottom: 15px;
            }

            .sidebar .divider {
                border: 0; 
                height: 1px; 
                width: 75%; 
                margin: 8px auto; 
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border-radius: 2px; 
            }

            /* Button Styles */
            .btn-primary {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border: none;
                border-radius: 8px;
                padding: 10px 20px;
                font-weight: 500;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--secondary), var(--primary));
                box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            }

            /* Table Styles */
            .table-container {
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            }

            .table th {
                background-color: #f8f9fa;
                font-weight: 600;
                color: #495057;
                border-top: none;
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

            /* Badge Styles */
            .badge-success {
                background: linear-gradient(135deg, #4cc9f0, #4895ef);
            }

            .badge-warning {
                background: linear-gradient(135deg, #f72585, #e63946);
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
                        <a href="/admin/dashboard" class="navbar-brand d-flex align-items-center">
                            <img src="/uploads/logo.png" alt="Logo GoNet" class="brand-logo me-2">
                            <span class="arsip-surat">Sistem Kas - <span class="brand-name">Gonet</span></span>
                        </a>
                    </div>

                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <span><?= session()->get('username') ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><span class="dropdown-item-text">Role: <?= ucfirst(session()->get('role')) ?></span></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= service('uri')->getSegment(2) === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('admin/dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('uri')->getSegment(2) === 'users' ? 'active' : '' ?>" href="<?= site_url('admin/users') ?>">
                            <i class="bi bi-person-badge"></i> <span>Manajemen User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('uri')->getSegment(2) === 'laporan' ? 'active' : '' ?>" href="<?= site_url('admin/laporan') ?>">
                            <i class="bi bi-bar-chart"></i> <span>Laporan</span>
                        </a>
                    </li>
                    <li class="divider">
                        <hr class="dropdown-divider my-2">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('uri')->getSegment(2) === 'kas_masuk' ? 'active' : '' ?>" href="<?= site_url('admin/kas_masuk') ?>">
                            <i class="bi bi-cash-coin"></i> <span>Kas Masuk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('uri')->getSegment(2) === 'kas_keluar' ? 'active' : '' ?>" href="<?= site_url('admin/kas_keluar') ?>">
                            <i class="bi bi-cash-stack"></i> <span>Kas Keluar</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= service('uri')->getSegment(2) === 'pengajuan' ? 'active' : '' ?>" href="<?= site_url('admin/pengajuan') ?>">
                            <i class="bi bi-clipboard-check"></i> <span>Pengajuan</span>
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-danger" href="<?= site_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
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
            document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('mobile-expanded');
                document.getElementById('mainContent').classList.toggle('mobile-expanded');
            });

            // Initialize DataTables if table exists
            document.addEventListener('DOMContentLoaded', function() {
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
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        </script>

        <?= $this->renderSection('scripts') ?>
    </body>

    </html>
<?php else : ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Akses Ditolak - Sistem Kas GoNet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #4361ee, #3f37c9);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Poppins', sans-serif;
            }

            .access-denied {
                background: white;
                padding: 3rem;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                text-align: center;
                max-width: 500px;
            }

            .access-denied i {
                font-size: 5rem;
                color: #e63946;
                margin-bottom: 1.5rem;
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