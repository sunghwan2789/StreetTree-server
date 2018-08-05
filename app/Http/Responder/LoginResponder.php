<?php
namespace App\Http\Responder;

use Slim\Http\Response;
use App\Entity\User;
use App\Transformer\UserTransformer;
use App\Service\Transformer;
use Slim\Http\Cookies;
use Psr\Container\ContainerInterface;

class LoginResponder
{
    /**
     * @var Transformer
     */
    private $transformer;

    private $cookieSecure;

    public function __construct(Transformer $transformer, ContainerInterface $container)
    {
        $this->transformer = $transformer;
        $this->cookieSecure = $container->get('settings.jwtauth')['secure'];
    }

    public function grant(Response $response, string $token, User $user): Response
    {
        $cookies = new Cookies();
        $cookies->set(getenv('JWTAUTH_NAME'), [
            'value'    => $token,
            // TODO: 토큰 시간 설정
            'expires'  => time() + 72800,
            'httponly' => true,
            'secure'   => $this->cookieSecure,
        ]);
        return $response->withStatus(200)
            ->withAddedHeader('Set-Cookie', $cookies->toHeaders())
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
