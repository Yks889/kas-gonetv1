<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h1 class="mb-4">Laporan Kas & Aktivitas</h1>

    <div class="row">
        <!-- Diagram Batang Kas -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-bar-chart"></i> Ringkasan Kas
                </div>
                <div class="card-body">
                    <canvas id="kasChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Diagram Lingkaran Pengajuan -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pie-chart"></i> Ringkasan Pengajuan
                </div>
                <div class="card-body" style="height:371px">
                    <canvas id="pengajuanUserChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Aktivitas User -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
               <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
    <div>
        <i class="bi bi-clock-history"></i> Aktivitas User
    </div>
    <div>
        <span class="badge bg-primary">Total User: <?= $total_user ?></span>
    </div>
</div>


                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Aktivitas</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($activities)): ?>
                                <?php $no=1; foreach ($activities as $act): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($act['username']) ?></td>
                                        <td><?= esc($act['role']) ?></td>
                                        <td><?= esc($act['activity']) ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($act['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada aktivitas</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Ringkasan Kas
    const kasLabels = ['Kas Masuk', 'Kas Keluar', 'Saldo'];
    const kasData = [
        <?= (float) $total_masuk['total'] ?>,
        <?= (float) $total_keluar['total'] ?>,
        <?= (float) $saldo['saldo_akhir'] ?? 0 ?>
    ];

    new Chart(document.getElementById('kasChart'), {
        type: 'bar',
        data: {
            labels: kasLabels,
            datasets: [{
                label: 'Jumlah (Rp)',
                data: kasData,
                backgroundColor: [
                    'rgba(0, 200, 83, 0.7)',   
                    'rgba(255, 99, 132, 0.7)', 
                    'rgba(54, 162, 235, 0.7)',
                ],
                borderColor: [
                    'rgba(0, 200, 83, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Ringkasan Kas' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Data Ringkasan Pengajuan (Tanpa Total User)
    const pieLabels = ['Total Pengajuan', 'Pengajuan Pending', 'Pengajuan Ditolak'];
    const pieData = [
        <?= (int) $total_pengajuan ?>,
        <?= (int) $pengajuan_pending ?>,
        <?= (int) $pengajuan_ditolak ?>,
    ];

    new Chart(document.getElementById('pengajuanUserChart'), {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: [
                    'rgba(255, 159, 64, 0.7)',  
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(255, 99, 132, 0.7)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: { display: true, text: 'Ringkasan Pengajuan' }
            }
        }
    });
</script>

<?= $this->endSection() ?>
