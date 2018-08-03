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

    public function findByCode(...$codes)
    {
        @[$siCode, $guCode, $dongCode] = $codes;
        $qb = $this->repository->createQueryBuilder('m')
            ->select('m')
            ->where('m.siCode = :siCode')
            ->setParameter('siCode', $siCode);
        if (isset($guCode)) {
            $qb->andWhere('m.guCode = :guCode')
            ->setParameter('guCode', $guCode);
        }
        if (isset($dongCode)) {
            $qb->andWhere('m.dongCode = :dongCode')
            ->setParameter('dongCode', $dongCode);
        }
        $query = $qb->getQuery();
        return $query->getResult();
    }
}
