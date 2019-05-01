<?php

namespace App\Service;

use App\Entity\Category;
use App\Tests\ApplicationTestCase;


class CategoryServiceTest extends ApplicationTestCase
{
    /**
     * @var CategoryService|object|null
     */
    private $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->container->get(CategoryService::class);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreate()
    {
        $this->service->create('test');
        /** @var Category $category */
        $category = $this->entityManager->getRepository(Category::class)->findOneByName('test');
        $this->assertSame($category->getName(), 'test');
    }
}
