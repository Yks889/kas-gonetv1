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

        <style>
            :root {
                --primary-color: #4da3ff;
                --secondary-color: #ff6b6b;
                --bg-dark: #0f0f0f;
                --bg-card: #141414;
                --bg-hover: #1f1f1f;
                --border-color: #2c2c2c;
                --text-primary: #ffffff;
                --text-secondary: #aaaaaa;
                --gradient-primary: linear-gradient(135deg, #4361ee, #4cc9f0);
                --gradient-card: linear-gradient(135deg, #1a1a1a, #2a2a2a);
                --shadow-light: 0 4px 12px rgba(0, 0, 0, 0.1);
                --shadow-medium: 0 6px 20px rgba(0, 0, 0, 0.15);
                --shadow-glow: 0 0 20px rgba(77, 163, 255, 0.3);
            }

            body {
                font-family: 'Montserrat', sans-serif;
                background-color: var(--bg-dark);
                color: var(--text-primary);
                margin: 0;
                overflow-x: hidden;
            }

            /* Sidebar Modern */
            .sidebar {
                width: 280px;
                background: var(--bg-card);
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                padding: 25px 0;
                border-right: 1px solid var(--border-color);
                display: flex;
                flex-direction: column;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1000;
                box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3);
            }

            .sidebar .logo {
                font-size: 1.4rem;
                font-weight: 700;
                padding: 0 25px;
                margin-bottom: 35px;
                color: var(--text-primary);
                display: flex;
                align-items: center;
                gap: 12px;
                transition: all 0.3s ease;
            }

            .sidebar .logo img {
                transition: transform 0.3s ease;
            }

            .sidebar .logo:hover img {
                transform: scale(1.05);
            }

            .sidebar-divider {
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--border-color), transparent);
                margin: 15px 25px;
                opacity: 0.6;
            }

            .sidebar .nav-link {
                color: var(--text-secondary);
                padding: 14px 20px;
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 0.95rem;
                font-weight: 500;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 12px;
                margin: 4px 15px;
                position: relative;
                overflow: hidden;
            }

            .sidebar .nav-link::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 3px;
                background: var(--primary-color);
                transform: scaleY(0);
                transition: transform 0.3s ease;
                border-radius: 0 4px 4px 0;
            }

            .sidebar .nav-link i {
                font-size: 1.3rem;
                color: var(--text-secondary);
                transition: all 0.3s ease;
                width: 24px;
                text-align: center;
            }

            .sidebar .nav-link.active,
            .sidebar .nav-link:hover {
                background: var(--bg-hover);
                color: var(--text-primary);
                transform: translateX(5px);
                box-shadow: var(--shadow-light);
            }

            .sidebar .nav-link.active::before,
            .sidebar .nav-link:hover::before {
                transform: scaleY(1);
            }

            .sidebar .nav-link.active i,
            .sidebar .nav-link:hover i {
                color: var(--primary-color);
                transform: scale(1.1);
            }

            /* Header Modern */
            .main-header {
                position: fixed;
                top: 0;
                left: 280px;
                right: 0;
                height: 70px;
                background: var(--bg-card);
                border-bottom: 1px solid var(--border-color);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 30px;
                z-index: 999;
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }

            .main-header .title {
                font-size: 1.3rem;
                font-weight: 600;
                color: var(--text-primary);
                background: var(--gradient-primary);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            /* Content Area */
            .main-content {
                margin-left: 280px;
                padding: 30px;
                min-height: 100vh;
                transition: all 0.3s ease;
            }

            /* ========== MODERN PROFILE SECTION - DIPERBAIKI ========== */
            .sidebar-profile {
                margin-top: auto;
                padding: 20px 15px 20px;
                border-top: 1px solid var(--border-color);
                background: rgba(0, 0, 0, 0.2);
                backdrop-filter: blur(10px);
            }

            .profile-card {
                background: var(--gradient-card);
                border-radius: 12px;
                padding: 15px;
                margin: 0 10px 12px 10px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
                box-shadow: var(--shadow-light);
                height: 70px;
                display: flex;
                align-items: center;
            }

            .profile-card:hover {
                transform: translateX(5px);
                box-shadow: var(--shadow-medium);
                border-color: var(--primary-color);
            }

            .profile-avatar {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid var(--primary-color);
                box-shadow: var(--shadow-glow);
                transition: all 0.3s ease;
                flex-shrink: 0;
            }

            .profile-avatar-placeholder {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: var(--gradient-primary);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                border: 2px solid rgba(255, 255, 255, 0.2);
                box-shadow: var(--shadow-glow);
                transition: all 0.3s ease;
                flex-shrink: 0;
            }

            .profile-card:hover .profile-avatar,
            .profile-card:hover .profile-avatar-placeholder {
                transform: scale(1.05);
                border-color: #4cc9f0;
            }

            .profile-avatar-placeholder i {
                font-size: 1.3rem;
            }

            .profile-info {
                flex: 1;
                margin-left: 12px;
                min-width: 0;
            }

            .profile-name {
                font-weight: 600;
                font-size: 0.9rem;
                color: var(--text-primary);
                margin-bottom: 2px;
                line-height: 1.2;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .profile-role {
                font-size: 0.7rem;
                color: var(--text-secondary);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                line-height: 1.2;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .profile-link {
                display: block;
                text-decoration: none;
                color: inherit;
                transition: all 0.3s ease;
            }

            /* Modern Logout Button - DIPERBAIKI */
            .logout-btn {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 14px 18px;
                color: var(--secondary-color);
                border-radius: 12px;
                transition: all 0.3s ease;
                text-decoration: none;
                font-size: 0.95rem;
                font-weight: 500;
                margin: 0 10px;
                background: rgba(255, 107, 107, 0.05);
                border: 1px solid transparent;
                height: 50px;
            }

            .logout-btn:hover {
                background: rgba(255, 107, 107, 0.1);
                color: #ff8e8e;
                border-color: rgba(255, 107, 107, 0.3);
                transform: translateX(5px);
                box-shadow: 0 4px 12px rgba(255, 107, 107, 0.2);
            }

            .logout-btn i {
                font-size: 1.3rem;
                transition: transform 0.3s ease;
            }

            .logout-btn:hover i {
                transform: translateX(2px);
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
                    border-radius: 10px;
                    width: 45px;
                    height: 45px;
                    color: white;
                    font-size: 1.2rem;
                    cursor: pointer;
                    box-shadow: var(--shadow-medium);
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
                backdrop-filter: blur(5px);
            }

            .sidebar-overlay.active {
                display: block;
            }

            /* Smooth animations */
            .sidebar,
            .main-content,
            .main-header {
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Scrollbar styling */
            .sidebar::-webkit-scrollbar {
                width: 6px;
            }

            .sidebar::-webkit-scrollbar-track {
                background: transparent;
            }

            .sidebar::-webkit-scrollbar-thumb {
                background: var(--border-color);
                border-radius: 3px;
            }

            .sidebar::-webkit-scrollbar-thumb:hover {
                background: var(--primary-color);
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
                <img src="<?= base_url('uploads/logo.png') ?>" alt="Logo" style="height: 45px; width: auto;">
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
                        <i class="bi bi-person-badge"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li><a class="nav-link <?= service('uri')->getSegment(2) === 'laporan' ? 'active' : '' ?>"
                        href="<?= site_url('admin/laporan') ?>">
                        <i class="bi bi-journal-text"></i>
                        <span>Aktivitas User</span>
                    </a>
                </li>
                <li>
                    <div class="sidebar-divider"></div>
                </li>
                 <li><a class="nav-link <?= service('uri')->getSegment(2) === 'informasi_kas' ? 'active' : '' ?>"
                        href="<?= site_url('admin/informasi_kas') ?>">
                        <i class="bi bi-cash-coin"></i>
                        <span>Informasi Kas</span>
                    </a>
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

            <!-- Profile & Logout Section - DIPERBAIKI -->
            <div class="sidebar-profile">
                <!-- Profile Card -->
                <?php
                $userModel = new \App\Models\UserModel();
                $sidebarUser = $userModel->find(session()->get('id'));
                ?>
                <a class="profile-link <?= service('uri')->getSegment(2) === 'profile' ? 'active' : '' ?>"
                    href="<?= site_url(session()->get('role') === 'admin' ? 'admin/profile' : 'user/profile') ?>">
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

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const sidebar = document.getElementById('sidebar');
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                const sidebarOverlay = document.getElementById('sidebarOverlay');

                // Mobile menu toggle
                function toggleMobileMenu() {
                    sidebar.classList.toggle('mobile-open');
                    sidebarOverlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
                }

                mobileMenuBtn.addEventListener('click', toggleMobileMenu);
                sidebarOverlay.addEventListener('click', toggleMobileMenu);

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

                // Photo upload forms
                const photoForms = document.querySelectorAll('form[action*="update-photo"]');
                photoForms.forEach(form => {
                    form.addEventListener('submit', function (e) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    });
                });

                // Add resize listener for responsive behavior
                window.addEventListener('resize', function () {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('mobile-open');
                        sidebarOverlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });
        </script>
    </body>

    </html>
<?php endif; ?>