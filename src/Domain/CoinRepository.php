<?php
declare(strict_types = 1);


namespace App\Domain;


use App\Domain\Coin;
use App\Domain\CoinNotFoundException;

interface CoinRepository
{
    /** @throws CoinNotFoundException */
    public function getById(string $id): Coin;

    /** @return Coin[] */
    public function getAll(): array;

    public function save(Coin $coin): void;

    /** @throws CoinNotFoundException */
    public function delete(string $id): void;
}