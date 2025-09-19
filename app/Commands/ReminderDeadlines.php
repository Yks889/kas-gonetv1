<?php
namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\PengajuanService;

class ReminderDeadlines extends BaseCommand
{
    protected $group = 'Application';
    protected $name = 'remind:deadlines';
    protected $description = 'Mengirim reminder untuk pengajuan yang sudah melewati deadline';

    public function run(array $params)
    {
        $pengajuanService = new PengajuanService();
        $count = $pengajuanService->cekDeadlinePengajuan();

        if ($count > 0) {
            CLI::write('Mengirim ' . $count . ' reminder deadline pengajuan', 'green');
        } else {
            CLI::write('Tidak ada pengajuan yang melewati deadline', 'yellow');
        }
    }
}