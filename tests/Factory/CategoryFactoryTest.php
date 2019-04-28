<?php

namespace App\Factory;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_create_category()
    {
        $category = CategoryFactory::create('test');
        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame($category->getName(), 'test');
    }
}
