<?php

namespace App\Support\ValueObjects;

use App\Support\Traits\Makeable;
use InvalidArgumentException;
use Stringable;

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'USD' => '$',
        'EUR' => '€',
        'UAH' => '₴',
    ];

    public function __construct(
        private readonly int $amount,
        private readonly string $currency = 'USD',
        private readonly int $precision = 2,
    ) {
        if ($this->amount < 0) {
            throw new InvalidArgumentException('Price amount must be greater than or equal to 0');
        }

        if (! array_key_exists($this->currency, $this->currencies)) {
            throw new InvalidArgumentException('Currency is not supported');
        }
    }

    public function __toString(): string
    {
        return number_format($this->amount(), $this->precision, ',', ' ').' '.$this->currencySymbol();
    }

    public function amount(): float|int
    {
        return $this->amount / 10 ** $this->precision;
    }

    public function rawAmount(): int
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function currencySymbol(): string
    {
        return $this->currencies[$this->currency];
    }
}
