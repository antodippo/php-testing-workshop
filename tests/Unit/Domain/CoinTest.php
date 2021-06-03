<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Coin;
use App\Domain\InvalidCurrencyException;
use PHPUnit\Framework\TestCase;

class CoinTest extends TestCase
{
    public function test_it_can_be_created_from_an_array_and_exported_to_an_array(): void
    {
        // Arrange
        $coin = Coin::fromArray([
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => 0.50,
            'currency' => 'EUR',
            'year' => '2012'
        ]);

        // Act
        $actualArray = $coin->toArray();

        // Assert
        $expectedArray = [
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => "0.50 EUR",
            'year' => '2012',
            'valueEUR' => null
        ];
        self::assertSame($expectedArray, $actualArray);
    }

    public function test_it_updates_the_value_in_euro(): void
    {
        // Arrange
        $coin = Coin::fromArray([
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => 2,
            'currency' => 'EUR',
            'year' => '2012'
        ]);

        // Act
        $coin->updateValueEUR(1.5);

        // Assert
        $actualArray = $coin->toArray();
        $expectedArray = [
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => "2.00 EUR",
            'year' => '2012',
            'valueEUR' => "3.00 EUR",
        ];
        self::assertSame($expectedArray, $actualArray);
    }

    public function test_it_cannot_be_created_with_invalid_currency(): void
    {
        // Assert
        self::expectException(InvalidCurrencyException::class);
        self::expectExceptionMessage("'ZZZ' is not a valid currency");

        // Arrange, Act
        $coin = Coin::fromArray([
            'id' => '6cfa0d5a-1cb9-41c3-a292-d926723c686f',
            'description' => 'A beautiful coin',
            'amount' => 2,
            'currency' => 'ZZZ',
            'year' => '2012'
        ]);
    }

}
