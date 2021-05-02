<?php
declare(strict_types = 1);

namespace App\Infrastructure\CoinValuePersister;


use App\Domain\Coin;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpCoinRatesProvider implements CoinRatesProvider
{
    public function __construct(private HttpClientInterface $httpClient) {}

    public function getRateToEUR(Coin $coin): float
    {
        $response = $this->httpClient->request(
            'GET',
            "https://api.ratesapi.io/api/latest?base={$coin->getCurrency()}"
        )->toArray();

        if (isset($response['rates']['EUR'])) {
            return (float) $response['rates']['EUR'];
        }

        throw new RateNotFoundException("Rate not found for coin {$coin->getId()}");
    }
}