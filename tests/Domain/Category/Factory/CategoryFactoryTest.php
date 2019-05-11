<?php

namespace App\Tests\Domain\Category\Factory;

use App\Domain\Category\Category;
use App\Domain\Category\Factory\CategoryFactory;
use PHPUnit\Framework\TestCase;

class CategoryFactoryTest extends TestCase
{
    public function test_it_create_category()
    {
        $category = CategoryFactory::create('test');
        $this->assertSame($category->getName(), 'test');
    }
}
