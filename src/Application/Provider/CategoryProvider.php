<?php

declare(strict_types=1);

namespace App\Application\Provider;

use App\Application\Collection;
use App\Domain\Category\Category;
use App\Domain\Category\Repository\CategoryRepositoryInterface;

class CategoryProvider
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(int $page, int $limit): Collection
    {
        $data = $this->categoryRepository->getAllCategory($page, $limit);
        $serializedData = [];
        /** @var Category $datum */
        foreach ($data['data'] as $datum) {
            $serializedData[] = $datum->serialize();
        }
        $collection = new Collection($page, $limit, (int) $data['count'], $serializedData);

        return $collection;
    }
}
