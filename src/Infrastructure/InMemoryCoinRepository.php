<?php


namespace App\Infrastructure;


use App\Domain\Coin;
use App\Domain\CoinNotFoundException;
use App\Domain\CoinRepository;

class InMemoryCoinRepository implements CoinRepository
{
    /** @var Coin[]  */
    private array $coins = [];

    public function getById(string $id): Coin
    {
        if (array_key_exists($id, $this->coins)) {
            return $this->coins[$id];
        }

        throw new CoinNotFoundException();
    }

    public function getAll(): array
    {
        return $this->coins;
    }

    public function save(Coin $coin): void
    {
        $this->coins[$coin->getId()] = $coin;
    }

    public function delete(string $id): void
    {
        if (array_key_exists($id, $this->coins)) {
            unset($this->coins[$id]);
            return;
        }

        throw new CoinNotFoundException();
    }
}