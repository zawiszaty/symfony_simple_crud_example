<?php

declare(strict_types=1);

namespace App\Infrastructure\Category\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use App\Infrastructure\Shared\Adapter\EntityManagerAdapterInterface;
use App\Infrastructure\Shared\Repository\MysqlRepository;

class CategoryRepository extends MysqlRepository implements CategoryRepositoryInterface
{
    public function __construct(EntityManagerAdapterInterface $entityManager)
    {
        $this->class = Category::class;
        parent::__construct($entityManager);
    }

    /**
     * @param string|null $name
     *
     * @return Category|null
     */
    public function findOneByName(?string $name): ?Category
    {
        /** @var Category|null $category */
        $category = $this->repository->findOneBy(['name' => $name]);

        return $category;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return array
     */
    public function getAllCategory(int $page, int $limit): array
    {
        $qb = $this
            ->repository
            ->createQueryBuilder('category')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
        $model = $qb->getQuery()->execute();
        $qbCount = $this
            ->repository
            ->createQueryBuilder('category')
            ->select('count(category.id)');
        $count = $qbCount->getQuery()->execute();
        $data = [
            'data' => $model,
            'count' => $count,
        ];

        return $data;
    }

    /**
     * @param Category $category
     */
    public function save(Category $category): void
    {
        $this->register($category);
    }
}
