<?php
namespace App\Http;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

class Kernel extends App
{
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions(__DIR__ . '/../config.php');
    }
}
