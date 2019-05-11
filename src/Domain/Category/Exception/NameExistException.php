<?php

declare(strict_types=1);

namespace App\Domain\Category\Exception;

class NameExistException extends \Exception
{
    protected $message = 'Category Name Exist';
}
