<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Repository;

use App\Infrastructure\Shared\Adapter\EntityManagerAdapterInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MysqlRepository.
 */
abstract class MysqlRepository
{
    /** @var string */
    protected $class;
    /** @var EntityRepository */
    protected $repository;
    /**
     * @var EntityManagerAdapterInterface
     */
    protected $entityManager;

    /**
     * MysqlRepository constructor.
     *
     * @param EntityManagerAdapterInterface $entityManager
     */
    public function __construct(EntityManagerAdapterInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->setRepository($this->class);
    }

    /**
     * @param object $model
     */
    public function register(object $model): void
    {
        $this->entityManager->persist($model);
        $this->apply();
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param QueryBuilder $queryBuilder
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    protected function oneOrException(QueryBuilder $queryBuilder)
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
        if (null === $model) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    private function setRepository(string $model): void
    {
        /** @var EntityRepository $objectRepository */
        $objectRepository = $this->entityManager->getRepository($model);
        $this->repository = $objectRepository;
    }
}
