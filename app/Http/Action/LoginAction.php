<?php
namespace App\Http\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Service\AuthService;
use App\Http\Responder\LoginResponder;
use App\Repository\UserRepository;

class LoginAction
{
    /**
     * @var LoginResponder
     */
    private $responder;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var AuthService
     */
    private $auth;

    public function __construct(
        LoginResponder $responder,
        UserRepository $repository,
        AuthService $auth
    ) {
        $this->responder = $responder;
        $this->repository = $repository;
        $this->auth = $auth;
    }

    public function __invoke(Request $request, Response $response)
    {
        $username = $request->getParsedBodyParam('id');
        $password = $request->getParsedBodyParam('pw');

        // FIXME: $username 자료형이 array이면 여러 아이디를 한번에 질의함
        $user = $this->repository->findOneByUsername($username);
        if ($user === null) {
            return $this->responder->userNotFound($response);
        }

        try {
            $this->auth->attemptLogin($user, $password);
        } catch (\InvalidArgumentException $e) {
            return $this->responder->incorrectPassword($response);
        } catch (\TypeError | \Exception $e) {
            return $this->responder->unknownError($response, $e->getMessage());
        }

        // TODO: Refresh Token 발급하고 짧은 단위로 갱신하기
        $token = $this->auth->issueToken($user);
        return $this->responder->grant($response, $token);
    }
}
