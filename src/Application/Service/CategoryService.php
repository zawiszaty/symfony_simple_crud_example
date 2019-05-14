<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Category\Factory\CategoryFactory;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use App\Domain\Category\Validator\CategoryValidatorInterface;

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
     * @var CategoryValidatorInterface
     */
    private $categoryValidator;

    /**
     * CategoryService constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param CategoryValidatorInterface  $categoryValidator
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository, CategoryValidatorInterface $categoryValidator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryValidator = $categoryValidator;
    }

    /**
     * @param string $name
     *
     * @throws \App\Domain\Category\Exception\NameExistException
     */
    public function create(string $name): void
    {
        $this->categoryValidator->categoryNameNotExist($name);
        $this->categoryRepository->save(
            CategoryFactory::create($name)
        );
    }
}
