<?php

namespace App\Tests\Unit\Infrastructure\CoinValuePersister;

use App\Domain\Coin;
use App\Infrastructure\CoinValuePersister\HttpCoinRatesProvider;
use App\Infrastructure\CoinValuePersister\RateNotFoundException;
use App\Tests\Stub\CoinStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ServerException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class HttpCoinRatesProviderTest extends TestCase
{
    public function test_it_returns_the_correct_euro_rate(): void
    {
        //Arrange
        $mockHttpClient = new MockHttpClient([
            new MockResponse('{
                "base": "GBP",
                "rates": {
                    "EUR": 1.56547,
                    "USD": 1.67289
                },
                "date": "2021-04-01"
            }')
        ]);
        $coinRatesProvider = new HttpCoinRatesProvider($mockHttpClient);
        $coin = CoinStub::getGBPCoin();

        // Act
        $rate = $coinRatesProvider->getRateToEUR($coin);

        // Assert
        self::assertSame(1.56547, $rate);
    }

    public function test_it_throws_exception_when_no_rates_found(): void
    {
        //Arrange
        $mockHttpClient = new MockHttpClient([
            new MockResponse('{
                "base": "GBP",
                "rates": {
                    "AUD": 2.78965,
                    "USD": 1.67289
                },
                "date": "2021-04-01"
            }')
        ]);
        $coinRatesProvider = new HttpCoinRatesProvider($mockHttpClient);
        $coin = Coin::fromArray([
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => 1,
            'currency' => 'GBP',
            'year' => '2012'
        ]);

        // Assert
        self::expectException(RateNotFoundException::class);

        // Act
        $rate = $coinRatesProvider->getRateToEUR($coin);
    }

    public function test_it_throws_exception_when_it_gets_error_from_rates_service(): void
    {
        //Arrange
        $mockHttpClient = new MockHttpClient([
            new MockResponse('', ['http_code' => 500])
        ]);
        $coinRatesProvider = new HttpCoinRatesProvider($mockHttpClient);
        $coin = Coin::fromArray([
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => 1,
            'currency' => 'GBP',
            'year' => '2012'
        ]);

        // Assert
        self::expectException(ServerException::class);

        // Act
        $rate = $coinRatesProvider->getRateToEUR($coin);
    }

}
