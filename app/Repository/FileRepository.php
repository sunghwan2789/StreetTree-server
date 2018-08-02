<?php
namespace App\Repository;

use App\Entity\File;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

final class FileRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(File::class);
    }

    public function find($id): ?File
    {
        return $this->repository->find($id);
    }
}
