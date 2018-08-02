<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\MeasureMetadata;


class MeasureResponder
{
    public function show(Response $response, MeasureMetadata $measureSet): Response
    {
        return $response->withStatus(200)
            ->withJson($measureSet);
    }
}
