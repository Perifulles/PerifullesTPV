<?php

namespace App\Restaurant\Domain\ValueObject;

class TaxId
{
    private const MIN_LENGTH = 9;

    private const MAX_LENGTH = 14;

    private string $value;

    private function __construct(string $value)
    {
        $length = strlen($value);
        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            throw new \InvalidArgumentException(
                sprintf('Tax ID must be between %d and %d characters.', self::MIN_LENGTH, self::MAX_LENGTH)
            );
        }
        $this->value = $value;
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }
}