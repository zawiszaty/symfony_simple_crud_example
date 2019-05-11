<?php

namespace App\Tests\Application\Provider;

use App\Application\Collection;
use App\Application\Provider\CategoryProvider;
use App\Domain\Category\Factory\CategoryFactory;
use App\Infrastructure\Category\Repository\InMemoryCategoryRepository;
use App\Tests\Application\ApplicationTestCase;

class CategoryProviderTest extends ApplicationTestCase
{
    /**
     * @var InMemoryCategoryRepository
     */
    private $repository;

    /**
     * @var CategoryProvider
     */
    private $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryCategoryRepository();
        $this->provider = new CategoryProvider($this->repository);
    }

    public function test_it_get_all_category()
    {
        for ($i = 0; $i < 30; $i++) {
            $category = CategoryFactory::create('test'.$i);
            $this->repository->save($category);
        }
        $data = $this->provider->getAll(1, 10);
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertSame($data->page, 1, 'page');
        $this->assertSame($data->limit, 10, 'limit');
        $this->assertSame($data->total, 30, 'total');
        $this->assertSame(count($data->data), 10);
    }
}
