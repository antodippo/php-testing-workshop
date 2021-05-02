<?php

namespace App\Tests\Integration\Infrastructure;

use App\Infrastructure\InMemoryCoinRepository;
use PHPUnit\Framework\TestCase;

class InMemoryCoinRepositoryTest extends TestCase
{
    use CoinRepositoryTestTrait;

    private InMemoryCoinRepository $coinRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->coinRepository = new InMemoryCoinRepository();
    }
}
