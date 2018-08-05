<?php
namespace App\Service;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use App\Entity\User;
use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use \DateTime;

class AuthService
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * 로그인을 시도하고 오류 시 Exception을 발생한다.
     *
     * TODO: 상황에 맞는 Exception 정의하기
     * ex) IncorrectPasswordException, DisabledUserException
     *
     * @throws \InvalidArgumentException 비밀번호 불일치
     */
    public function attemptLogin(User $user, string $password)
    {
        // TODO: 비밀번호 암호화 저장 시 사용
        // if (!hash_equals($user->password, crypt($password, $user->password))) {
        if (!hash_equals($user->password, $password)) {
            throw new \InvalidArgumentException('password incorrect');
        }
    }

    /**
     * Stateless하게 회원을 확인할 수 있는 토큰을 발행한다.
     */
    public function issueToken(User $user): string
    {
        $issuedAt = new DateTime();
        $expiresAt = new DateTime('+1 day');
        return JWT::encode([
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expiresAt->getTimestamp(),
            'i' => $user->id,
            'n' => $user->fullName,
        ], getenv('JWTAUTH_SECRET'));
    }

    /**
     * Generate a secure hash for a given password. The cost is passed
     * to the blowfish algorithm. Check the PHP manual page for crypt to
     * find more information about this setting.
     */
    private static function generateHash($password, $cost=11): string
    {
        /* To generate the salt, first generate enough random bytes. Because
         * base64 returns one character for each 6 bits, the we should generate
         * at least 22*6/8=16.5 bytes, so we generate 17. Then we get the first
         * 22 base64 characters
         */
        // $salt=substr(base64_encode(openssl_random_pseudo_bytes(17)),0,22);
        $salt=substr(base64_encode(random_bytes(17)),0,22);
        /* As blowfish takes a salt with the alphabet ./A-Za-z0-9 we have to
         * replace any '+' in the base64 string with '.'. We don't have to do
         * anything about the '=', as this only occurs when the b64 string is
         * padded, which is always after the first 22 characters.
         */
        $salt=str_replace("+",".",$salt);
        /* Next, create a string that will be passed to crypt, containing all
         * of the settings, separated by dollar signs
         */
        $param='$'.implode('$',array(
            "2y", //select the most secure version of blowfish (>=PHP 5.3.7)
            str_pad($cost,2,"0",STR_PAD_LEFT), //add the cost in two digits
            $salt //add the salt
        ));
        //now do the actual hashing
        return crypt($password,$param);
    }
}
