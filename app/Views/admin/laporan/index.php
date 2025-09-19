<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h1 class="mb-4">Aktivitas User</h1>
    <!-- Tabel Aktivitas User -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
               <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
    <div>
        <i class="bi bi-clock-history"></i> Aktivitas User
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


<?= $this->endSection() ?>
