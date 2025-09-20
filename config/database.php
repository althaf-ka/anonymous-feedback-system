<?php

declare(strict_types=1);

use Core\Env;

return [
    'host'     => Env::get('DB_HOST'),
    'port'     => Env::get('DB_PORT'),
    'database' => Env::get('DB_NAME'),
    'user'     => Env::get('DB_USER'),
    'password' => Env::get('DB_PASSWORD'),
    'charset'  => Env::get('DB_CHARSET', 'utf8mb4'),
];
