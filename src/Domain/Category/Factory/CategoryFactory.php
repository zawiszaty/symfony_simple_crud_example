<?php

declare(strict_types=1);

namespace App\Domain\Category\Factory;

use App\Domain\Category\Category;
use DateTime;

class CategoryFactory
{
    public static function create(string $name): Category
    {
        return new Category($name, new DateTime());
    }
}
