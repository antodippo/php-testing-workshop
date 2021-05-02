<?php
declare(strict_types = 1);

namespace App\Infrastructure\CoinValuePersister;


use App\Domain\Coin;
use App\Infrastructure\CoinValuePersister\RateNotFoundException;

interface CoinRatesProvider
{
    /** @throws RateNotFoundException */
    public function getRateToEUR(Coin $coin): float;

}