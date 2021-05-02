<?php

namespace App\Tests\Unit\Infrastructure;

use App\Infrastructure\CoinPayloadValidator;
use PHPUnit\Framework\TestCase;

class CoinPayloadValidatorTest extends TestCase
{
    public function test_it_validates_correct_payload(): void
    {
        // Arrange
        $coinPayloadValidator = new CoinPayloadValidator();
        $payload = [
            'description' => '',
            'amount' => '',
            'currency' => '',
            'year' => ''
        ];

        // Act
        $result = $coinPayloadValidator->validate($payload);

        // Assert
        self::assertTrue($result);
    }

    /** @dataProvider getWrongPayloads */
    public function test_it_doesnt_validate_wrong_payloads(array $payload): void
    {
        // Arrange
        $coinPayloadValidator = new CoinPayloadValidator();

        // Act
        $result = $coinPayloadValidator->validate($payload);

        // Assert
        self::assertFalse($result);
    }

    public function getWrongPayloads()
    {
        return [
            [
                [
                    'amount' => 1,
                    'currency' => 'GBP',
                    'year' => '2006'
                ]
            ],
            [
                [
                    'description' => 'A beautiful coin',
                    'currency' => 'GBP',
                    'year' => '2006'
                ]
            ],
            [
                [
                    'description' => 'A beautiful coin',
                    'amount' => 1,
                    'year' => '2006'
                ]
            ],
            [
                [
                    'description' => 'A beautiful coin',
                    'amount' => 1,
                    'currency' => 'GBP'
                ]
            ]
        ];
    }
}
