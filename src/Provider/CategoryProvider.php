<?php

declare(strict_types=1);

namespace App\Provider;

use App\Common\Collection;
use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryProvider
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
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
        $collection = new Collection($page, $limit, (int)$data['count'][0][1], $serializedData);

        return $collection;
    }
}
