<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$app = new App\Http\Kernel();

$app->any('/', App\Http\Action\HomeAction::class);
$app->get('/dump', App\Http\Action\DumpAction::class);
$app->post('/login', App\Http\Action\LoginAction::class);
$app->post('/upload', App\Http\Action\FileUploadAction::class);
$app->post('/measure/new', App\Http\Action\MeasureCreateAction::class);
// $app->get('/measure/search', App\Http\Action\MeasureSearchAction::class);
$app->get('/measure/{meta_id}', App\Http\Action\MeasureShowAction::class);
$app->get('/measure/{meta_id}/{measure_id}/root-image', App\Http\Action\RootImageDownloadAction::class);

$app->add(Tuupola\Middleware\JwtAuthentication::class);

$app->run();
