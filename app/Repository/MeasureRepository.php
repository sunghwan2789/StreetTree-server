<?php
namespace App\Repository;

use App\Entity\Measure;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class MeasureRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(Measure::class);
    }

    public function find($id): ?Measure
    {
        return $this->repository->find($id);
    }
}
