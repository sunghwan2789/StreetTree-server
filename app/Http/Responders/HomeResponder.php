<?php
namespace App\Http\Responders;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Models\HttpRequest;

class HomeResponder
{
    public function __construct()
    {
    }

    public function echo(Response $response, HttpRequest $request)
    {
        $body = $response->getBody();
        $body->write($request->method . "\n");
        $body->write(implode("\n", $request->headers) . "\n");
        $body->write($request->body);
        return $response->withHeader('Content-Type', 'text/plain;charset=utf-8');
    }
}
