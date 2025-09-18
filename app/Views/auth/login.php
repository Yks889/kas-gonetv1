<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Kas GONET - Login</title>
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
            --dark-bg: #121212;
            --card-bg: rgba(26, 26, 26, 0.95);
            --text-light: #f8f9fa;
            --text-muted: #adb5bd;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url("<?= base_url('uploads/bg-img1.jpg') ?>") no-repeat center center;
            background-size: cover;
            position: relative;
            color: var(--text-light);
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(18, 18, 18, 0.9) 0%, rgba(26, 26, 26, 0.85) 100%);
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1000px;
            padding: 20px;
        }

        .login-box {
            background: var(--card-bg);
            border-radius: 12px;
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left (Form Login) */
        .login-left {
            flex: 1;
            padding: 40px;
            min-width: 300px;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group-text {
            background: rgba(42, 42, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--accent-color);
            border-radius: 8px 0 0 8px;
        }

        .form-control {
            background: rgba(42, 42, 42, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff !important;
            padding: 12px 15px;
            border-radius: 0 8px 8px 0;
        }

        .form-control:focus {
            background: rgba(42, 42, 42, 0.9);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            border-color: var(--primary-color);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--accent-color);
        }

        .btn-login {
            background: var(--gradient-primary);
            border: none;
            color: var(--text-light);
            font-weight: 600;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }

        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            margin: 20px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 10px;
        }

        .help-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: var(--accent-color);
            font-size: 0.9rem;
        }

        .help-link:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Right (Info) */
        .login-right {
            flex: 1;
            padding: 40px;
            min-width: 300px;
            background: rgba(26, 26, 26, 0.7);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar-logo {
            width: 120px;
            margin-bottom: 10px;
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .sidebar-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .feature-list li {
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .feature-list i {
            color: var(--accent-color);
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-box {
                flex-direction: column;
            }

            .login-left {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Left: Login Form -->
            <div class="login-left">
                <div class="login-header text-center mb-4">
                    <h2>Selamat Datang 👋</h2>
                    <p>Masuk untuk mengakses Sistem Kas GONET</p>
                </div>

                <form action="<?= site_url('login') ?>" method="post">
                    <!-- Username -->
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Nama Pengguna" required>
                    </div>

                    <!-- Password -->
                    <div class="input-group position-relative">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Kata Sandi" required>
                        <span class="password-toggle" id="passwordToggle">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                    <!-- Remember me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider"><span>atau</span></div>

                <!-- Help -->
                <a href="<?= site_url('register') ?>" class="help-link">
                    <i class="fas fa-user-plus me-2"></i>Belum punya akun? Daftar sekarang
                </a>

            </div>

            <!-- Right: Info & Features -->
            <div class="login-right">
                <div class="sidebar-header">
                    <img src="<?= base_url('uploads/logo.png') ?>" alt="GONET Logo" class="sidebar-logo" />
                    <h1 class="sidebar-title">Sistem Kas GONET</h1>
                    <p class="sidebar-subtitle">Solusi Manajemen Keuangan Modern</p>
                </div>

                <h2>Kelola Keuangan dengan Mudah dan Efisien</h2>
                <ul class="feature-list list-unstyled ps-0">
                    <li><i class="fas fa-check-circle"></i> Pencatatan transaksi secara real-time</li>
                    <li><i class="fas fa-check-circle"></i> Laporan keuangan otomatis dan lengkap</li>
                    <li><i class="fas fa-check-circle"></i> Manajemen kas multi-user dengan hak akses</li>
                    <li><i class="fas fa-check-circle"></i> Backup data otomatis tanpa khawatir kehilangan</li>
                    <li><i class="fas fa-check-circle"></i> Keamanan data dengan enkripsi tingkat tinggi</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        // Toggle password
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');
        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!passwordInput.value || !document.getElementById('username').value) {
                e.preventDefault();
                alert('Harap isi semua field yang diperlukan');
            }
        });
    </script>
</body>

</html>