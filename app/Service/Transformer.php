<?php
namespace App\Service;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Serializer\ApiSerializer;

class Transformer
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * Create a new transformer service provider
     *
     * @param Manager    $fractal
     */
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
        $this->fractal->setSerializer(new ApiSerializer());
    }

    /**
     * Fractal respond with collection
     *
     * @param  array    $collection
     * @param  callable $callback
     *
     * @return array
     */
    public function collection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
        $data     = $this->fractal->createData($resource)->toArray();
        return $data;
    }

    /**
     * Fractal respond with item
     *
     * @param  array    $item
     * @param  callable $callback
     *
     * @return array
     */
    public function item($item, $callback)
    {
        $resource = new Item($item, $callback);
        $data     = $this->fractal->createData($resource)->toArray();
        return $data;
    }
}
