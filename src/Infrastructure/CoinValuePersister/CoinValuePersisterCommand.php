<?php
declare(strict_types = 1);

namespace App\Infrastructure\CoinValuePersister;


use App\Domain\CoinRepository;
use App\Infrastructure\CoinValuePersister\CoinValuePersister;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CoinValuePersisterCommand extends Command
{
    protected static $defaultName = 'coins:update-value';

    public function __construct(
        private CoinRepository $coinRepository,
        private CoinValuePersister $coinValuePersister
    ) {
        parent::__construct();
    }


    protected function configure(): void
    {
        $this->setDescription('Updates the EUR value of the coins.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $coins = $this->coinRepository->getAll();
        foreach ($coins as $coin) {
            try {
                $this->coinValuePersister->persist($coin);
                $output->writeln("Coin value updated for {$coin->getId()}");
            } catch (RateNotFoundException $e) {
                $output->writeln("Coin rate not found for {$coin->getId()}");
            }
        }

        return Command::SUCCESS;
    }
}