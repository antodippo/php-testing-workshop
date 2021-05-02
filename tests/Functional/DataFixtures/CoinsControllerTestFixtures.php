<?php

namespace App\Tests\Functional\DataFixtures;

use App\Tests\Stub\CoinStub;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoinsControllerTestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $coin1 = CoinStub::getGBPCoin();
        $manager->persist($coin1);
        $coin2 = CoinStub::getGBPCoinWithId('63f125dd-7597-46d9-951e-271c8a815df9');
        $manager->persist($coin2);
        $coin3 = CoinStub::getUSDCoin();
        $manager->persist($coin3);

        $manager->flush();
    }
}
