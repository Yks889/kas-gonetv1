<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use App\Filters\AuthFilter;
use App\Filters\AdminOnly;
use App\Filters\UserOnly;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'     => CSRF::class,
        'toolbar'  => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'auth'     => AuthFilter::class,
        'admin'    => AdminOnly::class,
        'user'     => UserOnly::class,
    ];

    public $filters = [
        'auth' => [
            'before' => [
                'admin/*',
                'user/*',
            ],
        ],
    ];
}