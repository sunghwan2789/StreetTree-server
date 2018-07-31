<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\RootImage;

final class RootImageResponder
{
    public function success(Response $response, RootImage $rootImage)
    {
        return $response->withStatus(201)
            ->withJson([
                'id' => $rootImage->id,
            ]);
    }
}
