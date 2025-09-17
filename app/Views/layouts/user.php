<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kas GoNet - User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        img {
            height: 35px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container-fluid">
             <a href="/user/dashboard" class="navbar-brand" id="sidebarToggle">
          <img src="/uploads/logo.png" alt="Logo Gonet" class="brand-logo">
          <span class="arsip-surat">Sistem Kas <span class="brand-name">GONET</span></span>
        </a>

            <div class="d-flex ms-auto">
                <span class="navbar-text text-white me-3">
                    Halo, <?= session()->get('username') ?> (<?= ucfirst(session()->get('role')) ?>)
                </span>
                <a class="btn btn-sm btn-outline-light" href="<?= site_url('logout') ?>">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Layout utama -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url('user/dashboard') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= site_url('user/pengajuan/index') ?>">
                                <i class="bi bi-pencil-square"></i> Pengajuan Kas
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Konten -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>