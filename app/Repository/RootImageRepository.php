<?php
namespace App\Repository;

use App\Entity\RootImage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class RootImageRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(RootImage::class);
    }

    public function find($id): ?RootImage
    {
        return $this->repository->find($id);
    }
}
