<?php

declare(strict_types=1);

namespace App\Service;

use App\Factory\CategoryFactory;
use Doctrine\ORM\EntityManagerInterface;

final class CategoryService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $name): void
    {
        $category = CategoryFactory::create($name);
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }
}
