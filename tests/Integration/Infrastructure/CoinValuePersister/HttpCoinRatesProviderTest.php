<?php

namespace App\Tests\Integration\Infrastructure\CoinValuePersister;

use App\Domain\Coin;
use App\Infrastructure\CoinValuePersister\HttpCoinRatesProvider;
use App\Infrastructure\CoinValuePersister\RateNotFoundException;
use App\Tests\Stub\CoinStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class HttpCoinRatesProviderTest extends TestCase
{
    public function test_it_connects_to_the_rates_service(): void
    {
        //Arrange
        $coinRatesProvider = new HttpCoinRatesProvider(HttpClient::create());
        $coin = CoinStub::getUSDCoin();

        // Act
        $rate = $coinRatesProvider->getRateToEUR($coin);

        // Assert
        self::assertIsFloat($rate);
        self::greaterThan(0);
    }
}
