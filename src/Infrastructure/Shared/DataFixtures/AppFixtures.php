<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\DataFixtures;

use App\Domain\Category\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 30; ++$i) {
            $manager->persist(CategoryFactory::create('test category'.$i));
        }
        $manager->flush();
    }
}
