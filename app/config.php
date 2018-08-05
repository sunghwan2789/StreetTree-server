<?php

use Psr\Container\ContainerInterface;

return [
    'settings.storagePath' => __DIR__ . '/../storage',

    'settings.fileStoragePath' => __DIR__ . '/../storage/files',

    'settings.doctrine' => [
        'meta' => [
            'entity_path' => [
                __DIR__ . '/Entity',
            ],
            'auto_generate_proxies' => true,
            'proxy_dir'   =>  __DIR__ . '/../storage/doctrine/proxies',
            'cache'       => null,
        ],
        'connection' => [
            'driver'   => 'pdo_mysql',
            'host'     => getenv('DB_HOST'),
            'dbname'   => getenv('DB_DATABASE'),
            'user'     => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset'  => 'utf8mb4',
            'defaultTableOptions' => [
                'charset' => 'utf8mb4',
                'collate' => 'utf8mb4_unicode_ci',
            ],
        ],
    ],

    'settings.jwtauth' => [
        'path'      => ['/'],
        'ignore'    => ['/login'],
        'secure'    => false,
        'cookie'    => getenv('JWTAUTH_NAME'),
        'attribute' => getenv('JWTAUTH_NAME'),
        'secret'    => getenv('JWTAUTH_SECRET'),
    ],
];
