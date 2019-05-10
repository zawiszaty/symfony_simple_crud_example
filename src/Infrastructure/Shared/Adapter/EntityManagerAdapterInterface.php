<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Adapter;

interface EntityManagerAdapterInterface
{
    public function persist(object $model): void;

    public function flush(): void;

    public function getRepository(string $model): object;
}
