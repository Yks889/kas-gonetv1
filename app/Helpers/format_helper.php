<?php
if (!function_exists('format_rupiah')) {
    function format_rupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($date, $format = 'd/m/Y H:i')
    {
        if (!$date) return '-';
        return date($format, strtotime($date));
    }
}

if (!function_exists('get_status_badge')) {
    function get_status_badge($status)
    {
        $badges = [
            'pending' => 'secondary',
            'diproses' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger'
        ];
        
        return $badges[$status] ?? 'secondary';
    }
}

if (!function_exists('upload_file')) {
    function upload_file($file, $path, $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'])
    {
        if (!$file->isValid()) {
            throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
        }

        if (!in_array($file->getExtension(), $allowedTypes)) {
            throw new \RuntimeException('Jenis file tidak diizinkan');
        }

        if ($file->getSize() > 2097152) { // 2MB
            throw new \RuntimeException('Ukuran file terlalu besar (maks 2MB)');
        }

        $newName = $file->getRandomName();
        $file->move($path, $newName);

        return $newName;
    }
}

if (!function_exists('get_user_role')) {
    function get_user_role()
    {
        $session = session();
        return $session->get('role');
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return get_user_role() === 'admin';
    }
}

if (!function_exists('is_teknisi')) {
    function is_teknisi()
    {
        return get_user_role() === 'teknisi';
    }
}

if (!function_exists('is_penagih')) {
    function is_penagih()
    {
        return get_user_role() === 'penagih';
    }
}