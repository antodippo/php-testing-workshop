<?php
declare(strict_types = 1);


namespace App\Infrastructure;


use App\Domain\Coin;
use App\Domain\CoinNotFoundException;
use App\Domain\CoinRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineCoinRepository implements CoinRepository
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getById(string $id): Coin
    {
        $coin = $this->entityManager
            ->getRepository(Coin::class)
            ->findOneBy(['id' => $id]);

        if (! $coin instanceof Coin) {
            throw new CoinNotFoundException();
        }

        return $coin;
    }

    /** @return Coin[] */
    public function getAll(): array
    {
        return $this->entityManager
            ->getRepository(Coin::class)
            ->findBy([], ['id' => 'ASC']);
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Coin $coin): void
    {
        $this->entityManager->persist($coin);
        $this->entityManager->flush();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(string $id): void
    {
        $coin = $this->getById($id);
        $this->entityManager->remove($coin);
        $this->entityManager->flush();
    }
}