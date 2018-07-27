<?php
require __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App();

$app->get('/', App\Http\Actions\HomeAction::class);

$app->run();
