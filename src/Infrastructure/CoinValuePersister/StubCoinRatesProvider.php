<?php
declare(strict_types = 1);


namespace App\Infrastructure\CoinValuePersister;


use App\Domain\Coin;

class StubCoinRatesProvider implements CoinRatesProvider
{

    public function getRateToEUR(Coin $coin): float
    {
        return 1.5;
    }
}