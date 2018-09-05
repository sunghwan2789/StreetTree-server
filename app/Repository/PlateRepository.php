<?php
namespace App\Repository;

use App\Entity\Plate;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class PlateRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(Plate::class);
    }

    public function find($id): ?Plate
    {
        return $this->repository->find($id);
    }

    public function findByStart($id)
    {
        $qb = $this->repository->createQueryBuilder('p')
            ->where('p.id LIKE :id')
            ->setParameter('id', "{$id}%");
        return $qb->getQuery()->getResult();
    }
}
