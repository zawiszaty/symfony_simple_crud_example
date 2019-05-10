<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Category\Factory\CategoryFactory;
use App\Domain\Category\Repository\CategoryRepositoryInterface;

/**
 * Class CategoryService.
 */
final class CategoryService
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param string $name
     */
    public function create(string $name): void
    {
        $this->categoryRepository->save(
            CategoryFactory::create($name)
        );
    }
}
