<?php

use function DI\create;
use function DI\get;
use function DI\string;

return [
    'settings.storagePath' => __DIR__ . '/../storage',
    'settings.dsn' => 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE') . ';charset=utf8mb4',

    App\Service\DumpService::class => create()
        ->constructor(string('{settings.storagePath}/dump')),

    PDO::class => create()
        ->constructor(get('settings.dsn'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [])
        ->method('setAttribute', PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
        ->method('setAttribute', PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC),
];
