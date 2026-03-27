<?php

namespace App\User\Domain\ValueObject;

class Pin
{
    private ?string $value;

    private function __construct(?string $value)
    {
        if ($value === null) {
            $this->value = null;
            return;
        }

        if (!preg_match('/^\d{4,6}$/', $value)) {
            throw new \InvalidArgumentException('PIN must be a string of 4 to 6 digits.');
        }

        $this->value = $value;
    }

    public static function create(?string $value): self
    {
        return new self($value);
    }

    public function value(): ?string
    {
        return $this->value;
    }
}
