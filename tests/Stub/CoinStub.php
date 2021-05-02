<?php


namespace App\Tests\Stub;


use App\Domain\Coin;
use Ramsey\Uuid\Uuid;

class CoinStub
{
    public static function getGBPCoin(): Coin
    {
        return Coin::fromArray([
            'id' => Uuid::uuid4()->toString(),
            'description' => 'A beautiful coin',
            'amount' => 1,
            'currency' => 'GBP',
            'year' => '2012'
        ]);
    }

    public static function getGBPCoinWithId(string $id): Coin
    {
        return Coin::fromArray([
            'id' => $id,
            'description' => 'A beautiful coin',
            'amount' => 1,
            'currency' => 'GBP',
            'year' => '2012'
        ]);
    }

    public static function getUSDCoin(): Coin
    {
        return Coin::fromArray([
            'id' => Uuid::uuid4()->toString(),
            'description' => 'A beautiful coin',
            'amount' => 1,
            'currency' => 'USD',
            'year' => '2012'
        ]);
    }
}