<?php

namespace App\Tests\Integration\Infrastructure;


use App\Domain\Coin;
use App\Domain\CoinNotFoundException;
use App\Tests\Stub\CoinStub;
use Ramsey\Uuid\Uuid;

trait CoinRepositoryTestTrait
{
    public function test_it_stores_and_retrieves_from_database(): void
    {
        // Arrange
        $coinId = Uuid::uuid4()->toString();
        $coin = CoinStub::getGBPCoinWithId($coinId);
        $this->coinRepository->save($coin);

        // Act
        $retrievedCoin = $this->coinRepository->getById($coinId);

        // Assert
        self::assertEquals($coin, $retrievedCoin);
    }

    public function test_it_throws_exception_when_trying_to_retrieve_a_non_existent_coin_from_database(): void
    {
        // Arrange
        for ($i = 1; $i <= 3; $i++) {
            $coin = CoinStub::getGBPCoinWithId(Uuid::uuid4()->toString());
            $this->coinRepository->save($coin);
        }

        // Assert
        self::expectException(CoinNotFoundException::class);

        // Act
        $this->coinRepository->getById(Uuid::uuid4()->toString());
    }

    public function test_it_retrieves_a_list_from_database(): void
    {
        // Arrange
        for ($i = 1; $i <= 5; $i++) {
            $coin = CoinStub::getGBPCoinWithId(Uuid::uuid4()->toString());
            $this->coinRepository->save($coin);
        }

        // Act
        $retrievedCoins = $this->coinRepository->getAll();

        // Assert
        self::assertCount(5, $retrievedCoins);
    }

    public function test_it_deletes_a_coin_from_database(): void
    {
        // Arrange
        for ($i = 1; $i <= 3; $i++) {
            $coinId = Uuid::uuid4()->toString();
            $coin = CoinStub::getGBPCoinWithId($coinId);
            $this->coinRepository->save($coin);
        }

        // Act
        $this->coinRepository->delete($coinId);

        // Assert
        self::assertCount(2, $this->coinRepository->getAll());
        self::expectException(CoinNotFoundException::class);
        $this->coinRepository->getById($coinId);
    }

    public function test_it_throws_exception_when_trying_to_delete_a_non_existent_coin_from_database(): void
    {
        // Arrange
        for ($i = 1; $i <= 3; $i++) {
            $coin = CoinStub::getGBPCoinWithId(Uuid::uuid4()->toString());
            $this->coinRepository->save($coin);
        }

        // Assert
        self::expectException(CoinNotFoundException::class);

        // Act
        $this->coinRepository->delete(Uuid::uuid4()->toString());
    }
}