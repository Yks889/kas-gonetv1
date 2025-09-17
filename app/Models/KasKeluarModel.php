<?php
namespace App\Models;

use CodeIgniter\Model;

class KasKeluarModel extends Model
{
    protected $table = 'kas_keluar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pengajuan_id', 'nominal', 'keterangan', 'file_nota'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}