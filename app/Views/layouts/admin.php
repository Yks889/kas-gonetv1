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

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --primary-color: #3b82f6;
                --primary-light: #60a5fa;
                --primary-dark: #2563eb;
                --secondary-color: #64748b;
                --accent-color: #10b981;
                --bg-dark: #0f172a;
                --bg-card: #1e293b;
                --bg-hover: #334155;
                --border-color: #334155;
                --text-primary: #f1f5f9;
                --text-secondary: #cbd5e1;
                --text-muted: #94a3b8;
                --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
                --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
                --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
                --border-radius: 8px;
                --transition: all 0.2s ease;
            }

            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg-dark);
                color: var(--text-primary);
                margin: 0;
                overflow-x: hidden;
                line-height: 1.6;
                font-weight: 400;
            }

            /* Sidebar Simple */
            .sidebar {
                width: 250px;
                background: var(--bg-card);
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                padding: 20px 0;
                border-right: 1px solid var(--border-color);
                display: flex;
                flex-direction: column;
                transition: var(--transition);
                z-index: 1000;
            }

            .sidebar .logo {
                font-size: 1.3rem;
                font-weight: 600;
                padding: 0 20px;
                margin-bottom: 30px;
                color: var(--text-primary);
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .sidebar .logo img {
                height: 35px;
                width: auto;
            }

            .sidebar-divider {
                height: 1px;
                background: var(--border-color);
                margin: 15px 20px;
            }

            /* Navigation Items */
            .sidebar .nav-link {
                color: var(--text-secondary);
                padding: 12px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                font-size: 0.9rem;
                font-weight: 500;
                transition: var(--transition);
                border-radius: 6px;
                margin: 2px 15px;
            }

            .sidebar .nav-link i {
                font-size: 1.2rem;
                color: var(--text-muted);
                transition: var(--transition);
                width: 20px;
                text-align: center;
            }

            /* Hover Effects - Simple */
            .sidebar .nav-link:hover {
                color: var(--text-primary);
                background: var(--bg-hover);
            }

            .sidebar .nav-link:hover i {
                color: var(--primary-color);
            }

            .sidebar .nav-link.active {
                color: var(--text-primary);
                background: var(--primary-color);
            }

            .sidebar .nav-link.active i {
                color: var(--text-primary);
            }

            /* Header Simple */
            .main-header {
                position: fixed;
                top: 0;
                left: 250px;
                right: 0;
                height: 70px;
                background: var(--bg-card);
                border-bottom: 1px solid var(--border-color);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 30px;
                z-index: 999;
            }

            .main-header .title {
                font-size: 1.25rem;
                font-weight: 600;
                color: var(--text-primary);
            }

            /* Content Area */
            .main-content {
                margin-left: 250px;
                padding: 30px;
                min-height: 100vh;
                transition: var(--transition);
                background: var(--bg-dark);
            }

            /* Profile Section */
            .sidebar-profile {
                margin-top: auto;
                padding: 15px 15px 20px;
                border-top: 1px solid var(--border-color);
            }

            .profile-card {
                background: var(--bg-card);
                border-radius: var(--border-radius);
                padding: 12px;
                margin: 0 10px 10px 10px;
                border: 1px solid var(--border-color);
                transition: var(--transition);
                display: flex;
                align-items: center;
            }

            .profile-card:hover {
                background: var(--bg-hover);
            }

            .profile-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid var(--border-color);
            }

            .profile-avatar-placeholder {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: var(--primary-color);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                border: 2px solid var(--border-color);
            }

            .profile-avatar-placeholder i {
                font-size: 1.1rem;
            }

            .profile-info {
                flex: 1;
                margin-left: 12px;
                min-width: 0;
            }

            .profile-name {
                font-weight: 600;
                font-size: 0.85rem;
                color: var(--text-primary);
                margin-bottom: 2px;
                line-height: 1.2;
            }

            .profile-role {
                font-size: 0.75rem;
                color: var(--text-muted);
                line-height: 1.2;
            }

            .profile-link {
                display: block;
                text-decoration: none;
                color: inherit;
            }

            /* Logout Button */
            .logout-btn {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 20px;
                color: var(--text-secondary);
                border-radius: 6px;
                transition: var(--transition);
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 500;
                margin: 0 10px;
            }

            .logout-btn:hover {
                color: #ef4444;
                background: rgba(239, 68, 68, 0.1);
            }

            .logout-btn i {
                font-size: 1.2rem;
            }

            /* Floating Button */
            .floating-btn {
                position: fixed;
                right: 25px;
                bottom: 25px;
                width: 50px;
                height: 50px;
                background: var(--primary-color);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.2rem;
                box-shadow: var(--shadow-md);
                cursor: pointer;
                z-index: 1000;
                transition: var(--transition);
                border: none;
            }

            .floating-btn:hover {
                background: var(--primary-dark);
                transform: translateY(-2px);
                box-shadow: var(--shadow-lg);
            }

            .floating-btn.hidden {
                opacity: 0;
                visibility: hidden;
                transform: scale(0.8);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%);
                    width: 280px;
                }

                .sidebar.mobile-open {
                    transform: translateX(0);
                }

                .main-header {
                    left: 0;
                }

                .main-content {
                    margin-left: 0;
                    padding: 20px 15px;
                }

                .mobile-menu-btn {
                    display: block !important;
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    z-index: 1001;
                    background: var(--primary-color);
                    border: none;
                    border-radius: 6px;
                    width: 40px;
                    height: 40px;
                    color: white;
                    font-size: 1.1rem;
                    cursor: pointer;
                }
            }

            @media (min-width: 769px) {
                .mobile-menu-btn {
                    display: none !important;
                }
            }

            /* Overlay for mobile */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Content Cards */
            .content-card {
                background: var(--bg-card);
                border-radius: var(--border-radius);
                padding: 20px;
                margin-bottom: 20px;
                border: 1px solid var(--border-color);
                box-shadow: var(--shadow-sm);
            }

            /* Table Styling */
            .table-modern {
                background: var(--bg-card);
                border-radius: var(--border-radius);
                overflow: hidden;
                border: 1px solid var(--border-color);
            }

            .table-modern th {
                background: rgba(59, 130, 246, 0.1);
                color: var(--text-primary);
                font-weight: 600;
                border-bottom: 1px solid var(--border-color);
                padding: 15px;
            }

            .table-modern td {
                padding: 12px 15px;
                border-bottom: 1px solid var(--border-color);
                color: var(--text-secondary);
            }

            .table-modern tr:last-child td {
                border-bottom: none;
            }

            .table-modern tr:hover td {
                background: rgba(59, 130, 246, 0.05);
            }

            /* Button Styling */
            .btn-modern {
                border-radius: 6px;
                padding: 10px 20px;
                font-weight: 500;
                transition: var(--transition);
                border: none;
            }

            .btn-primary-modern {
                background: var(--primary-color);
                color: white;
            }

            .btn-primary-modern:hover {
                background: var(--primary-dark);
            }

            /* Form Styling */
            .form-control-modern {
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                border-radius: 6px;
                color: var(--text-primary);
                padding: 10px 15px;
                transition: var(--transition);
            }

            .form-control-modern:focus {
                background: var(--bg-card);
                border-color: var(--primary-color);
                color: var(--text-primary);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
        </style>
    </head>

    <body>
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" id="mobileMenuBtn">
            <i class="bi bi-list"></i>
        </button>

        <!-- Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo">
                <span>Kas - GoNet</span>
            </div>

            <ul class="nav flex-column">
                <li>
                    <div class="sidebar-divider"></div>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'dashboard' ? 'active' : '' ?>"
                        href="<?= site_url('admin/dashboard') ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'users' ? 'active' : '' ?>"
                        href="<?= site_url('admin/users') ?>">
                        <i class="bi bi-people"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'activity' ? 'active' : '' ?>"
                        href="<?= site_url('admin/activity') ?>">
                        <i class="bi bi-activity"></i>
                        <span>Aktivitas User</span>
                    </a>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'laporan_kas' ? 'active' : '' ?>"
                        href="<?= site_url('admin/laporan_kas') ?>">
                        <i class="bi bi-graph-up"></i>
                        <span>Laporan Kas</span>
                    </a>
                </li>
                <li>
                    <div class="sidebar-divider"></div>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'kas_masuk' ? 'active' : '' ?>"
                        href="<?= site_url('admin/kas_masuk') ?>">
                        <i class="bi bi-cash-coin"></i>
                        <span>Kas Masuk</span>
                    </a>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'kas_keluar' ? 'active' : '' ?>"
                        href="<?= site_url('admin/kas_keluar') ?>">
                        <i class="bi bi-cash-stack"></i>
                        <span>Kas Keluar</span>
                    </a>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'pengajuan' ? 'active' : '' ?>"
                        href="<?= site_url('admin/pengajuan') ?>">
                        <i class="bi bi-clipboard-check"></i>
                        <span>Pengajuan</span>
                    </a>
                </li>
            </ul>

            <!-- Profile & Logout Section -->
            <div class="sidebar-profile">
                <!-- Profile Card -->
                <?php
                $userModel = new \App\Models\UserModel();
                $sidebarUser = $userModel->find(session()->get('id'));
                ?>
                <a class="profile-link" href="<?= site_url('admin/profile') ?>">
                    <div class="profile-card">
                        <div class="d-flex align-items-center w-100">
                            <div class="flex-shrink-0">
                                <?php
                                $photoPath = 'uploads/profiles/' . ($sidebarUser['photo'] ?? '');
                                if (isset($sidebarUser['photo']) && !empty($sidebarUser['photo']) && file_exists($photoPath)):
                                    ?>
                                    <img src="<?= base_url($photoPath) ?>" class="profile-avatar" alt="Foto Profil">
                                <?php else: ?>
                                    <div class="profile-avatar-placeholder">
                                        <i class="bi bi-person"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="profile-info">
                                <div class="profile-name"><?= session()->get('username') ?></div>
                                <div class="profile-role"><?= session()->get('role') ?></div>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Logout Button -->
                <a class="logout-btn" href="<?= site_url('logout') ?>">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        <!-- Main Content -->
        <main class="main-content">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Floating Button untuk kembali ke Dashboard -->
        <button class="floating-btn <?= service('uri')->getSegment(2) === 'dashboard' ? 'hidden' : '' ?>"
            id="floatingDashboardBtn">
            <i class="bi bi-house-door"></i>
        </button>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebar = document.getElementById('sidebar');
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                const sidebarOverlay = document.getElementById('sidebarOverlay');
                const floatingDashboardBtn = document.getElementById('floatingDashboardBtn');

                // Cek apakah sedang di halaman dashboard
                function isDashboardPage() {
                    const currentPath = window.location.pathname;
                    return currentPath.includes('/admin/dashboard') ||
                        currentPath.endsWith('/admin') ||
                        currentPath.endsWith('/admin/');
                }

                // Update visibility floating button
                function updateFloatingButtonVisibility() {
                    if (isDashboardPage()) {
                        floatingDashboardBtn.classList.add('hidden');
                    } else {
                        floatingDashboardBtn.classList.remove('hidden');
                    }
                }

                // Mobile menu toggle
                function toggleMobileMenu() {
                    sidebar.classList.toggle('mobile-open');
                    sidebarOverlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
                }

                mobileMenuBtn.addEventListener('click', toggleMobileMenu);
                sidebarOverlay.addEventListener('click', toggleMobileMenu);

                // Floating button functionality
                floatingDashboardBtn.addEventListener('click', function () {
                    if (!isDashboardPage()) {
                        window.location.href = "<?= site_url('admin/dashboard') ?>";
                    }
                });

                // Close sidebar when clicking on nav links in mobile
                const navLinks = document.querySelectorAll('.sidebar .nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 768) {
                            toggleMobileMenu();
                        }
                    });
                });

                // Handle image loading errors
                document.querySelectorAll('.profile-avatar').forEach(img => {
                    img.onerror = function () {
                        this.style.display = 'none';
                        const placeholder = this.nextElementSibling;
                        if (placeholder && placeholder.classList.contains('profile-avatar-placeholder')) {
                            placeholder.style.display = 'flex';
                        }
                    };
                });

                // Add resize listener
                window.addEventListener('resize', function () {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('mobile-open');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });

                // Update visibility saat pertama kali load
                updateFloatingButtonVisibility();
            });
        </script>
    </body>

    </html>
<?php endif; ?>