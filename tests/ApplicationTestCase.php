<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Kernel;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ApplicationTestCase extends TestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface|null
     */
    protected $container;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var Client
     */
    protected $client;

    protected function setUp(): void
    {
        $this->kernel = new Kernel('test', true);
        $this->kernel->boot();
        $this->container = $this->kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine.orm.entity_manager');
        $loader = new Loader();
        $loader->addFixture(new AppFixtures());
        $purger = new ORMPurger($this->entityManager);
        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures());
        $this->client = new Client(['base_uri' => 'http://nginx', 'http_errors' => false]);
    }
}
