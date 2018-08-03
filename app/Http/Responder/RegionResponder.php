<?php
namespace App\Http\Responder;

use App\Service\Transformer;
use Slim\Http\Response;
use App\Transformer\MeasuresetTransformer;

class RegionResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    public function __construct(
        Transformer $transformer
    ) {
        $this->transformer = $transformer;
    }

    public function collection(Response $response, $measures): Response
    {
        return $response->withStatus(200)
            ->withJson($this->transformer->collection($measures, new MeasuresetTransformer));
    }
}
