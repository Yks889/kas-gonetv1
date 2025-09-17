<?php
namespace App\Models;

use CodeIgniter\Model;

class KasSaldoModel extends Model
{
    protected $table = 'kas_saldo';
    protected $primaryKey = 'id';
    protected $allowedFields = ['saldo_akhir', 'updated_at'];    
    //protected $useTimestamps = true;
    protected $updatedField = 'updated_at';
}