<?php
namespace App\Models;

use CodeIgniter\Model;

class PengajuanFileModel extends Model
{
    protected $table = 'pengajuan_files';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pengajuan_id', 'file_name', 'file_path', 'file_type'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    public function getFilesByPengajuan($pengajuanId)
    {
        return $this->where('pengajuan_id', $pengajuanId)->findAll();
    }
}