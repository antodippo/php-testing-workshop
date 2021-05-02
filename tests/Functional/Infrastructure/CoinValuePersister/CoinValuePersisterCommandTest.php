<?php


namespace App\Tests\Functional\Infrastructure\CoinValuePersister;

use App\Domain\Coin;
use App\Tests\Functional\DataFixtures\CoinsControllerTestFixtures;
use App\Tests\Functional\DataFixtures\CoinValuePersisterCommandTestFixtures;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CoinValuePersisterCommandTest extends KernelTestCase
{
    use FixturesTrait;

    public function test_it_persists_value_of_coins()
    {
        // Arrange
        $kernel = static::createKernel();
        $this->loadFixtures([
            CoinValuePersisterCommandTestFixtures::class
        ]);
        $application = new Application($kernel);

        // Act
        $command = $application->find('coins:update-value');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        // Assert
        $output = $commandTester->getDisplay();
        self::assertStringContainsString('Coin value updated for 88dfb20c-79e9-4868-8a28-66b00a9caa66', $output);
        self::assertStringContainsString('Coin value updated for 63f125dd-7597-46d9-951e-271c8a815df9', $output);
    }
}