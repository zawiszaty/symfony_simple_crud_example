<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\CategoryFactory;
use App\Repository\CategoryRepository;

/**
 * Class CategoryService
 * @package App\Service
 */
final class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param string $name
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(string $name): void
    {
        $this->categoryRepository->save(
            CategoryFactory::create($name)
        );
    }
}
