<?php
namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class UserRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }

    public function findOneByUsername($username): ?User
    {
        return $this->repository->findOneBy([
            'username' => $username
        ]);
    }
}
