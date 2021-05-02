<?php

namespace App\Tests\Integration\Infrastructure;

use App\Infrastructure\DoctrineCoinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DoctrineCoinRepositoryTest extends WebTestCase
{
    use CoinRepositoryTestTrait;

    private ?EntityManagerInterface $entityManager;
    private DoctrineCoinRepository $coinRepository;

    public function setUp(): void
    {
        parent::setUp();
        static::createClient();
        $this->entityManager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->entityManager->getConnection()->executeQuery('DELETE FROM coin');
        $this->coinRepository = new DoctrineCoinRepository($this->entityManager);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->getConnection()->executeQuery('DELETE FROM coin');
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
