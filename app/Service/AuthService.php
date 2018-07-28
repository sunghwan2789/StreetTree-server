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
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function attemptLogin($username, $password): bool
    {
        $user = $this->repository->findOneByUsername($username);
        if ($user === null) {
            return false;
        }
        return true;
        return hash_equals($user->password, crypt($password, $user->password));
    }

    public function issueToken($username): string
    {
        $user = $this->repository->findOneByUsername($username);
        $issuedAt = new DateTime();
        $expiresAt = new DateTime('+1 day');
        return JWT::encode([
            'iat' => $issuedAt->getTimestamp(),
            'exp' => $expiresAt->getTimestamp(),
            'i' => $user->id,
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
