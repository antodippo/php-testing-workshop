<?php
declare(strict_types = 1);

namespace App\Infrastructure;

use Webmozart\Assert\Assert;

class CoinPayloadValidator
{
    public function validate(array $payload): bool
    {
        try {
            Assert::keyExists($payload, 'description');
            Assert::keyExists($payload, 'amount');
            Assert::keyExists($payload, 'currency');
            Assert::keyExists($payload, 'year');
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}