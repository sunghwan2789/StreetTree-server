<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$app = Slim\App();

$app->any('/', function ($req, $res) {
    return $req->getBody();
});

$app->run();
