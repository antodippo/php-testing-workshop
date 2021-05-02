<?php

namespace App\Tests\Functional\DataFixtures;

use App\Tests\Stub\CoinStub;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CoinValuePersisterCommandTestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $coin1 = CoinStub::getGBPCoinWithId('88dfb20c-79e9-4868-8a28-66b00a9caa66');
        $manager->persist($coin1);
        $coin2 = CoinStub::getGBPCoinWithId('63f125dd-7597-46d9-951e-271c8a815df9');
        $manager->persist($coin2);

        $manager->flush();
    }
}
