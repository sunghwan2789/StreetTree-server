<?php

use function DI\create;
use function DI\get;
use function DI\string;

return [
    'settings.storagePath' => __DIR__ . '/../storage',

    App\Service\DumpService::class => create()
        ->constructor(string('{settings.storagePath}/dump')),
];
