<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Adapter;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineEntityManagerAdapter implements EntityManagerAdapterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persist(object $model): void
    {
        $this->entityManager->persist($model);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function getRepository(string $model): object
    {
        return $this->entityManager->getRepository($model);
    }
}
