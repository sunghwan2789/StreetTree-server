<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

$app = new App\Http\Kernel();

$app->any('/', App\Http\Action\HomeAction::class);
$app->get('/dump', App\Http\Action\DumpAction::class);
$app->get('/db', function () {
    return $this->get('PDO')->quote('pojadf$!@#"<>BF\'AF#%)!(!@(#~Þr');
});

$app->run();
