<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'full_name', 'email', 'photo'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!empty($data['data']['password'])) {
            // Cek apakah password sudah di-hash dengan cara yang lebih reliable
            if (!$this->isAlreadyHashed($data['data']['password'])) {
                $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            }
        }
        return $data;
    }

    /**
     * Check if password is already hashed
     */
    protected function isAlreadyHashed($password)
    {
        // Password yang sudah di-hash biasanya memiliki:
        // - Panjang minimal 60 karakter
        // - Format khusus dengan prefix
        if (strlen($password) >= 60 && preg_match('/^\$2[ayb]\$.{56}$/', $password)) {
            return true;
        }
        return false;
    }
}