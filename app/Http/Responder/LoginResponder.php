<?php
namespace App\Http\Responder;

use Psr\Http\Message\ResponseInterface;

class LoginResponder
{
    public function respond(ResponseInterface $response, $token): ResponseInterface
    {
        if ($token) {
            setcookie('token', $token, time() + 72800, '/', '', false, true);
            return $response;
        } else {
            return $response->withStatus(403);
        }
    }
}
