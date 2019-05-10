<?php

declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Category;

interface CategoryRepositoryInterface
{
    public function findOneByName(?string $name): ?Category;

    public function getAllCategory(int $page, int $limit): array;

    public function save(Category $category): void;
}
