<?php

namespace App\Provider;

use App\Common\Collection;
use App\Tests\ApplicationTestCase;

class CategoryProviderTest extends ApplicationTestCase
{
    public function test_it_get_all_category()
    {
        /** @var CategoryProvider $provider */
        $provider = $this->container->get(CategoryProvider::class);
        $data = $provider->getAll(1, 10);
        $this->assertInstanceOf(Collection::class, $data);
        $this->assertSame($data->page, 1);
        $this->assertSame($data->limit, 10);
        $this->assertSame($data->total, 30);
        $this->assertSame(count($data->data), 10);
    }
}
