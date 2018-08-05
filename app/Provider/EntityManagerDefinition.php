<?php
namespace App\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

class EntityManagerDefinition extends AbstractContainerDefinition
{
    public function getSettingsKey(): string
    {
        return 'settings.doctrine';
    }

    public function __invoke(): array
    {
        return [
            EntityManager::class => function (ContainerInterface $container) {
                $settings = $this->getSettings($container);

                $config = Setup::createAnnotationMetadataConfiguration(
                    $settings['meta']['entity_path'],
                    $settings['meta']['auto_generate_proxies'],
                    $settings['meta']['proxy_dir'],
                    $settings['meta']['cache'],
                    false
                );

                return EntityManager::create($settings['connection'], $config);
            },
        ];
    }
}
