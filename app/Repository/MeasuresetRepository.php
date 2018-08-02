<?php
namespace App\Repository;

use App\Entity\Measureset;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class MeasuresetRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(Measureset::class);
    }

    public function find($id): ?Measureset
    {
        return $this->repository->find($id);
    }
}
