<?php
namespace App\Services;

use Psr\Container\ContainerInterface;

class DumpService
{
    private $path;

    private function getDumpPath()
    {
        return $this->path;
    }

    public function __construct($path)
    {
        $this->path = $path;
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
