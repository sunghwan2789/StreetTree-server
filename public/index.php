<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$app = new App\Http\Kernel();

$app->any('/', App\Http\Actions\HomeAction::class);
$app->get('/dump', App\Http\Actions\DumpAction::class);

$app->run();
