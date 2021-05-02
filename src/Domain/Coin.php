<?php
declare(strict_types = 1);


namespace App\Domain;


class Coin
{
    private ?float $valueEUR = null;

    private function __construct(
        private string $id,
        private string $description,
        private float $amount,
        private string $currency,
        private string $year
    ) {}

    /** @throws InvalidCurrencyException */
    public static function fromArray(array $array): Coin
    {
        if (! Currencies::isValid($array['currency'])) {
            throw new InvalidCurrencyException("'{$array['currency']}' is not a valid currency");
        }

        return new self(
            (string) $array['id'],
            (string) $array['description'],
            (float) $array['amount'],
            (string) $array['currency'],
            (string) $array['year'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount' => number_format($this->amount, 2) . " " . $this->currency,
            'year' => $this->year,
            'valueEUR' => $this->valueEUR ? number_format($this->valueEUR, 2) . " EUR" : null,
        ];
    }

    public function updateValueEUR(float $rate): void
    {
        $this->valueEUR = $this->amount * $rate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}