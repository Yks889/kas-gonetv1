<?php
namespace App\Models;

use CodeIgniter\Model;

class KasMasukModel extends Model
{
    protected $table = 'kas_masuk';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nominal', 'keterangan'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}