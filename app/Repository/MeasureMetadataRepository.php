<?php
namespace App\Repository;

use App\Entity\MeasureMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class MeasureMetadataRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(MeasureMetadata::class);
    }

    public function find($id): ?MeasureMetadata
    {
        return $this->repository->find($id);
    }
}
