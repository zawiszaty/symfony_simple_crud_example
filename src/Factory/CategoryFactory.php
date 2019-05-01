<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Category;
use DateTime;

class CategoryFactory
{
    public static function create(string $name): Category
    {
        return new Category($name, new DateTime());
    }
}
