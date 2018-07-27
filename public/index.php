<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new App\Http\Kernel();

$app->any('/', App\Http\Actions\HomeAction::class);
$app->get('/dump', App\Http\Actions\DumpAction::class);

$app->run();
