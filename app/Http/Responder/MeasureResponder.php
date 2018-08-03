<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\Measureset;
use App\Service\Transformer;
use App\Transformer\MeasuresetTransformer;

class MeasureResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function success(Response $response, Measureset $mesaureset): Response
    {
        return $response->withStatus(201)
            ->withJson($this->transformer->item($mesaureset, new MeasuresetTransformer));
    }

    public function show(Response $response, Measureset $measureSet): Response
    {
        return $response->withStatus(200)
            ->withJson($measureSet);
    }
}
