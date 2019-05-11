<?php

namespace App\Tests\Application\Service;

use App\Application\Service\CategoryService;
use App\Domain\Category\Category;
use App\Domain\Category\Exception\NameExistException;
use App\Infrastructure\Category\Repository\InMemoryCategoryRepository;
use App\Infrastructure\Category\Validator\CategoryValidator;
use App\Tests\Application\ApplicationTestCase;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class CategoryServiceTest extends ApplicationTestCase
{
    /**
     * @var CategoryService|object|null
     */
    private $service;
    /**
     * @var InMemoryCategoryRepository
     */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryCategoryRepository();
        $this->service = new CategoryService($this->repository, new CategoryValidator($this->repository));
    }

    public function test_create()
    {
        $this->service->create('test');
        /** @var Category $category */
        $category = $this->repository->findOneByName('test');
        $this->assertSame($category->getName(), 'test');
    }

    public function test_validate()
    {
        $this->expectException(NameExistException::class);
        $this->service->create('test');
        $this->service->create('test');
    }
}
