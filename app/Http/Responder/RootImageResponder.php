<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\RootImage;
use Slim\Http\Body;

final class RootImageResponder
{
    public function success(Response $response, RootImage $rootImage)
    {
        return $response->withStatus(201)
            ->withJson([
                'id' => $rootImage->id,
            ]);
    }

    public function download(Response $response, RootImage $rootImage)
    {
        // TODO: 파일 타입 파싱하기
        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/x-octet-stream')
            ->withBody(new Body($rootImage->data));
    }
}
