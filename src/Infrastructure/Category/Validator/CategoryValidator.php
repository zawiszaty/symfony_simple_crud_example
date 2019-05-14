<?php

declare(strict_types=1);

namespace App\Infrastructure\Category\Validator;

use App\Domain\Category\Exception\NameExistException;
use App\Domain\Category\Repository\CategoryRepositoryInterface;
use App\Domain\Category\Validator\CategoryValidatorInterface;

class CategoryValidator implements CategoryValidatorInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function categoryNameNotExist(string $name): void
    {
        if ($this->categoryRepository->findOneByName($name)) {
            throw new NameExistException();
        }
    }
}
