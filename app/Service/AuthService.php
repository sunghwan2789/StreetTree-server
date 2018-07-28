<?php
namespace App\Service;

use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use App\Entity\User;

class AuthService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function attemptLogin($username, $password)
    {
        return $this->em->getRepository(User::class)
            ->findOneBy([
                'username' => $username
            ]);
    }
}
