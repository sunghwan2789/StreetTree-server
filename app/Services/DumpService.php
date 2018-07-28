<?php
namespace App\Services;

use Psr\Container\ContainerInterface;

class DumpService
{
    private $storagePath;
    private function getDumpPath()
    {
        return $this->storagePath . '/dump';
    }

    public function __construct(ContainerInterface $container)
    {
        $this->storagePath = $container->get('settings.storage')['path'];
    }

    public function save($obj)
    {
        file_put_contents($this->getDumpPath(), json_encode($obj));
    }

    public function load()
    {
        return json_decode(file_get_contents($this->getDumpPath()));
    }
}
