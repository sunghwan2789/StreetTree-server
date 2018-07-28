<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$app = new App\Http\Kernel();

$app->any('/', App\Http\Action\HomeAction::class);
$app->get('/dump', App\Http\Action\DumpAction::class);
$app->post('/login', App\Http\Action\LoginAction::class);
$app->post('/survey/new', App\Http\Action\SurveyCreateAction::class);

$app->run();
