<?php
declare(strict_types = 1);


namespace App\Infrastructure\CoinValuePersister;


use App\Domain\Coin;
use App\Domain\CoinRepository;

class CoinValuePersister
{
    public function __construct(
        private CoinRatesProvider $coinRatesProvider,
        private CoinRepository $coinRepository
    ) {}

    public function persist(Coin $coin): Coin
    {
        $rateToEUR = $this->coinRatesProvider->getRateToEUR($coin);
        $coin->updateValueEUR($rateToEUR);
        $this->coinRepository->save($coin);

        return $coin;
    }
}