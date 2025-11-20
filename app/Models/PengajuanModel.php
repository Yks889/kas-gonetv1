<?php

namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'nominal', 'keterangan', 'deadline', 'status', 'tipe', 'confirm_at', 'deleted_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at'; // Tambahkan ini
    protected $useSoftDeletes = true; // Tambahkan ini untuk soft delete
}
