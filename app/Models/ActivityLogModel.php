<?php
namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'role',
        'activity',
        'description',
        'ip_address',
        'user_agent',
        'created_at'
    ];

    // ✅ konfigurasi timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';   // tidak pakai updated_at

    /**
     * Simpan log aktivitas user
     */
    public function logActivity($userId, $activity, $description = '')
    {
        $request = service('request');
        $session = session();

        $data = [
            'user_id'    => $userId,
            'role'       => $session->get('role') ?? 'guest',
            'activity'   => $activity,
            'description'=> $description,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent()->getAgentString(),
        ];

        return $this->insert($data);
    }

    /**
     * Ambil semua aktivitas 1 user
     */
    public function getUserActivities($userId, $limit = 50)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Ambil semua aktivitas (dengan join username)
     */
    public function getAllActivities($limit = 100)
    {
        return $this->select('activity_logs.*, users.username')
                    ->join('users', 'users.id = activity_logs.user_id', 'left')
                    ->orderBy('activity_logs.created_at', 'DESC')
                    ->findAll($limit);
    }
}
