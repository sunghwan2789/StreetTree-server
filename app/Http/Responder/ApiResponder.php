<?php
namespace App\Http\Responder;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiResponder
{
    public function __construct()
    {
    }

    public function json(Response $response, $obj): Response
    {
        $body = $response->getBody();
        $body->write(json_encode($obj));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
