<?php

declare(strict_types=1);

namespace App\Domain\Category\Validator;

interface CategoryValidatorInterface
{
    public function categoryNameNotExist(string $name): void;
}
