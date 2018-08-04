<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\User;
use App\Transformer\UserTransformer;
use App\Service\Transformer;

class LoginResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    public function __construct(Transformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function grant(Response $response, string $token, User $user): Response
    {
        setcookie(getenv('JWTAUTH_NAME'), $token, time() + 72800, '/', '', false /* sync with settings.jwtauth.secure */, true);
        return $response->withStatus(200)
            ->withJson($this->transformer->item($user, new UserTransformer()));
    }

    public function userNotFound(Response $response): Response
    {
        return $this->reject($response, 'USER_NOT_FOUND', '아이디가 없습니다.');
    }

    public function incorrectPassword(Response $response): Response
    {
        return $this->reject($response, 'INCORRECT_PASSWORD', '비밀번호가 틀렸습니다.');
    }

    public function unknownError(Response $response, $message): Response
    {
        return $this->reject($response, 'UNKNOWN_ERROR', $message);
    }

    protected function reject(Response $response, $error, string $message): Response
    {
        return $response->withStatus(403)
            ->withJson([
                'error' => $error,
                'message' => $message,
            ]);
    }
}
