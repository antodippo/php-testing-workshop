<?php

namespace App\Tests\Unit\Infrastructure\CoinValuePersister;

use App\Domain\Coin;
use App\Domain\CoinRepository;
use App\Infrastructure\CoinValuePersister\CoinRatesProvider;
use App\Infrastructure\CoinValuePersister\CoinValuePersister;
use App\Infrastructure\CoinValuePersister\HttpCoinRatesProvider;
use App\Infrastructure\CoinValuePersister\StubCoinRatesProvider;
use App\Infrastructure\InMemoryCoinRepository;
use App\Tests\Stub\CoinStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class CoinValuePersisterTest extends TestCase
{
    /**
     * In this case I use two stubs, StubCoinRatesProvider and InMemoryCoinRepository.
     * They act like the real ones, but they don't touch the DB or external services.
     */
    public function test_it_persists_the_value_with_stubs(): void
    {
        // Arrange
        $coin = CoinStub::getGBPCoin();
        $coinRatesProvider = new StubCoinRatesProvider();
        $coinRepository = new InMemoryCoinRepository();
        $coinRepository->save($coin);

        // Act
        $coinValuePersister = new CoinValuePersister(
            $coinRatesProvider,
            $coinRepository
        );
        $updatedCoin = $coinValuePersister->persist($coin);

        // Assert
        self::assertSame("1.50 EUR", $updatedCoin->toArray()["valueEUR"]);
    }

    /**
     * In this case I use the InMemoryCoinRepository stub, but I use the real HttpCoinRatesProvider,
     * injecting in it the MockHttpClient (provided by Symfony)
     */
    public function test_it_persists_the_value_with_real_rates_provider(): void
    {
        // Arrange
        $coin = CoinStub::getGBPCoin();
        $mockHttpClient = new MockHttpClient([
            new MockResponse('{
                "base": "GBP",
                "rates": {
                    "EUR": 1.50000
                },
                "date": "2021-04-28"
            }')
        ]);
        $coinRatesProvider = new HttpCoinRatesProvider($mockHttpClient);
        $coinRepository = new InMemoryCoinRepository();
        $coinRepository->save($coin);

        // Act
        $coinValuePersister = new CoinValuePersister(
            $coinRatesProvider,
            $coinRepository
        );
        $updatedCoin = $coinValuePersister->persist($coin);

        // Assert
        self::assertSame("1.50 EUR", $updatedCoin->toArray()["valueEUR"]);
    }

    /**
     * In this case I use mocks from PHPUnit (https://phpunit.de/manual/6.5/en/test-doubles.html)
     * It works, but the approach with more actual objects is preferable
     */
    public function test_it_persists_the_value_with_mocks(): void
    {
        // Arrange
        $coin = CoinStub::getGBPCoin();
        $coinRatesProvider = $this->createMock(CoinRatesProvider::class);
        $coinRatesProvider->method('getRateToEUR')->willReturn(1.5);
        $coinRepository = $this->createMock(CoinRepository::class);

        // Act
        $coinValuePersister = new CoinValuePersister(
            $coinRatesProvider,
            $coinRepository
        );
        $updatedCoin = $coinValuePersister->persist($coin);

        // Assert
        self::assertSame("1.50 EUR", $updatedCoin->toArray()["valueEUR"]);
    }
}
