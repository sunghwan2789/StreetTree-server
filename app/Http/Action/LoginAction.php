<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Http\Responder\ApiResponder;
use App\Service\AuthService;

class LoginAction
{
    /**
     * @var ApiResponder
     */
    private $responder;

    /**
     * @var AuthService
     */
    private $auth;

    public function __construct(
        ApiResponder $responder,
        AuthService $auth
    ) {
        $this->responder = $responder;
        $this->auth = $auth;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        return $this->responder->json($response, $this->auth->attemptLogin($body['id'], $body['pw']));
    }
}
