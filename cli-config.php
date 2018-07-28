<?php
require __DIR__ . '/vendor/autoload.php';

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Helper\HelperSet;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$settings = require __DIR__ . '/app/config.php';
$settings = $settings['settings.doctrine'];

$config = Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);
$em = EntityManager::create($settings['connection'], $config);

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($em->getConnection()),
]);
