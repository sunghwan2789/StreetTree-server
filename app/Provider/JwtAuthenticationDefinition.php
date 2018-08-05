<?php
namespace App\Provider;

use Tuupola\Middleware\JwtAuthentication;
use Psr\Container\ContainerInterface;

class JwtAuthenticationDefinition extends AbstractContainerDefinition
{
    public function getSettingsKey(): string
    {
        return 'settings.jwtauth';
    }

    public function __invoke(): array
    {
        return [
            JwtAuthentication::class => function (ContainerInterface $container) {
                return new JwtAuthentication($this->getSettings($container));
            }
        ];
    }
}
