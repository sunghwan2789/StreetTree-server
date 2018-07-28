<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Service\AuthService;
use App\Http\Responder\LoginResponder;

class LoginAction
{
    /**
     * @var LoginResponder
     */
    private $responder;

    /**
     * @var AuthService
     */
    private $auth;

    public function __construct(LoginResponder $responder, AuthService $auth)
    {
        $this->responder = $responder;
        $this->auth = $auth;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        if ($this->auth->attemptLogin($body['id'], $body['pw'])) {
            $token = $this->auth->issueToken($body['id']);
        }
        return $this->responder->respond($response, $token);
    }
}
