<?php

use Psr\Container\ContainerInterface;

return [
    'settings.storagePath' => __DIR__ . '/../storage',

    'settings.doctrine' => [
        'meta' => [
            'entity_path' => [
                __DIR__ . '/Entity',
            ],
            'auto_generate_proxies' => true,
            'proxy_dir'   =>  __DIR__ . '/../storage/doctrine/proxies',
            'cache'       => null,
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => getenv('DB_HOST'),
            'dbname' => getenv('DB_DATABASE'),
            'user' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ],
    ],

    App\Service\DumpService::class => function (ContainerInterface $c) {
        return new App\Service\DumpService($c->get('settings.storagePath') . '/dump');
    },

    Doctrine\ORM\EntityManager::class => function (ContainerInterface $c) {
        $settings = $c->get('settings.doctrine');

        $config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $settings['meta']['entity_path'],
            $settings['meta']['auto_generate_proxies'],
            $settings['meta']['proxy_dir'],
            $settings['meta']['cache'],
            false
        );

        return Doctrine\ORM\EntityManager::create($settings['connection'], $config);
    },
];
