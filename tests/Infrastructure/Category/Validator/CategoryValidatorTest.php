<?php

namespace App\Tests\Infrastructure\Category\Validator;

use App\Domain\Category\Exception\NameExistException;
use App\Domain\Category\Factory\CategoryFactory;
use App\Infrastructure\Category\Repository\InMemoryCategoryRepository;
use App\Infrastructure\Category\Validator\CategoryValidator;
use PHPUnit\Framework\TestCase;

class CategoryValidatorTest extends TestCase
{
    /**
     * @var CategoryValidator
     */
    private $validator;
    /**
     * @var InMemoryCategoryRepository
     */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->repository = new InMemoryCategoryRepository();
        $this->validator = new CategoryValidator($this->repository);
    }

    function test_it_validate_with_exist_name()
    {
        $this->expectException(NameExistException::class);
        $this->repository->save(CategoryFactory::create('test'));
        $this->validator->categoryNameNotExist('test');
    }

    function test_it_validate_with_not_exist_name()
    {
        $this->repository->save(CategoryFactory::create('test'));
        $this->validator->categoryNameNotExist('not exist name');
        $this->assertSame(1,1);
    }
}