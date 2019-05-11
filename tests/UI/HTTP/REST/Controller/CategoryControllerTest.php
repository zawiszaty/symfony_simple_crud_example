<?php

namespace App\Tests\UI\REST\Controller;

use App\Domain\Category\Category;
use App\Tests\UI\HTTP\HTTPTestCase;
use GuzzleHttp\RequestOptions;

class CategoryControllerTest extends HTTPTestCase
{
    public function test_create_category(): void
    {
        $response = $this->client->post('api/category', [
            RequestOptions::JSON => ['name' => 'test'],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => 'test']);
        $this->assertNotNull($category);
    }

    public function test_create_category_validation(): void
    {
        $response = $this->client->post('api/category', [
            RequestOptions::JSON => [],
        ]);
        $this->assertEquals(400, $response->getStatusCode());

        $response = $this->client->post('api/category', [
            RequestOptions::JSON => ['name' => 'test category1'],
        ]);
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_get_all_category(): void
    {
        $response = $this->client->get('api/category/1/10');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotNull($response->getBody()->getContents());
    }
}
