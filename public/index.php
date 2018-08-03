<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$app = new App\Http\Kernel();

$app->any('/', App\Http\Action\HomeAction::class);
$app->get('/dump', App\Http\Action\DumpAction::class);
$app->post('/login', App\Http\Action\LoginAction::class);
$app->post('/upload', App\Http\Action\FileUploadAction::class);
$app->post('/measureset/new', App\Http\Action\MeasuresetPostAction::class);
$app->get('/measureset/{measureset_id}', App\Http\Action\MeasuresetShowAction::class);
$app->get('/measure/{measure_id}/root-image', App\Http\Action\RootImageDownloadAction::class);
$app->get('/region/{codes:.*}', App\Http\Action\RegionMeasuresetSearchAction::class);

$app->add(Tuupola\Middleware\JwtAuthentication::class);

$app->run();
