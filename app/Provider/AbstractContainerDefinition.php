<?php
namespace App\Provider;

use Psr\Container\ContainerInterface;

abstract class AbstractContainerDefinition implements ContainerDefinitionInterface
{
    /**
     * 컨테이너에서 설정을 가져온다.
     *
     * @param $container 설정을 가져올 컨테이너
     *
     * @throws NotFoundException
     * @throws ContainerException
     *
     * @return mixed 설정
     */
    protected function getSettings(ContainerInterface $container)
    {
        return $container->get($this->getSettingsKey());
    }
}
