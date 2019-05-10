<?php

declare(strict_types=1);

namespace App\Infrastructure\Category\Repository;

use App\Domain\Category\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;

class InMemoryCategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @var array
     */
    private $categories = [];

    public function findOneByName(?string $name): ?Category
    {
        /** @var Category $category */
        foreach ($this->categories as $category) {
            if ($category->getName() === $name) {
                return $category;
            }
        }

        return null;
    }

    public function getAllCategory(int $page, int $limit): array
    {
        $data = [
            'data' => \array_slice($this->categories, \count($this->categories) - $limit),
            'count' => \count($this->categories),
        ];

        return $data;
    }

    public function save(Category $category): void
    {
        $this->categories[] = $category;
    }
}
