<?php

use App\Models\Guru;

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'gurus',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'gurus',
        ],
    ],

    'providers' => [
        'gurus' => [
            'driver' => 'eloquent',
            'model' => Guru::class,
        ],
    ],

    'passwords' => [
        'gurus' => [
            'provider' => 'gurus',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];