<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\Plate;
use App\Service\Transformer;
use App\Transformer\PlateTransformer;

class PlateResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function success(Response $response, Plate $plate): Response
    {
        return $response->withStatus(201)
            ->withJson($this->transformer->item($plate, new PlateTransformer()));
    }

    public function show(Response $response, Plate $plate): Response
    {
        return $response->withStatus(200)
            ->withJson($this->transformer->item($plate, new PlateTransformer()));
    }

    public function collection(Response $response, $plates): Response
    {
        return $response->withStatus(200)
            ->withJson($this->transformer->collection($plates, new PlateTransformer()));
    }
}
