<?php
namespace App\Http;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

class Kernel extends App
{
    /**
     * @inheritdoc
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        // $builder->addDefinitions(__DIR__ . '/../../config.php');

        // foreach ($this->getContainerDefinitions() as $definition) {
        //     $builder->addDefinitions($definition());
        // }
    }

    /**
     * @return ContainerDefinitionInterface[]
     */
    protected function getContainerDefinitions()
    {
        return [
            // new DoctrineDefinition(),
            // new TwigDefinition(),
        ];
    }
}
