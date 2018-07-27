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

    public function echo(Response $response, HttpRequest $request): Response
    {
        $body = $response->getBody();
        $body->write($request->method);
        $body->write("\n" . implode("\n", $request->headers));
        $body->write("\n\n" . $request->body);
        $body->write("\n\n" . implode("\n", $request->files));
        return $response->withHeader('Content-Type', 'text/plain;charset=utf-8');
    }
}
