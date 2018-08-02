<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\Measureset;


class MeasureResponder
{
    public function show(Response $response, Measureset $measureSet): Response
    {
        return $response->withStatus(200)
            ->withJson($measureSet);
    }
}
