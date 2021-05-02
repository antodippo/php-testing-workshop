<?php
declare(strict_types = 1);


namespace App\Domain;


class Currencies
{
    public const EUR = "EUR";
    public const USD = "USD";
    public const GBP = "GBP";
    public const AUD = "AUD";

    public static function getAll(): array
    {
        return [self::EUR, self::USD, self::GBP, self::AUD];
    }

    public static function isValid(string $currency): bool
    {
        return in_array($currency, self::getAll());
    }
}