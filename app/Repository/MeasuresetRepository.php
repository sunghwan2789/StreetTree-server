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

    public function findByCode(...$codes)
    {
        @[$siCode, $guCode, $dongCode] = $codes;
        $qb = $this->repository->createQueryBuilder('s')
            ->join('s.measures', 'm')
            ->where('m.siCode = :siCode')
            ->groupBy('s')
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

    public function findBySiteName($siteName)
    {
        $qb = $this->repository->createQueryBuilder('s')
            ->where('s.siteName LIKE :siteName')
            ->setParameter('siteName', "%{$siteName}%");
        return $qb->getQuery()->getResult();
    }
}
