<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$app = new App\Http\Kernel();

$app->post('/login', App\Http\Action\LoginAction::class);
$app->post('/upload', App\Http\Action\FileUploadAction::class);
$app->post('/measureset/new', App\Http\Action\MeasuresetPostAction::class);
$app->get('/measureset/region/{codes:.*}', App\Http\Action\MeasuresetRegionSearchAction::class);
$app->get('/measureset/search', App\Http\Action\MeasuresetSearchAction::class);
$app->get('/measureset/{measureset_id}', App\Http\Action\MeasuresetShowAction::class);
$app->put('/measureset/{measureset_id}', App\Http\Action\MeasuresetUpdateAction::class);
$app->get('/measure/{measure_id}/root-image', App\Http\Action\RootImageDownloadAction::class);
// TODO: 추가 예상 항목들
// $app->delete('/measure/{measure_id}/root-image');
// $app->delete('/measure/{measure_id}')

$app->add(Tuupola\Middleware\JwtAuthentication::class);

$app->run();
