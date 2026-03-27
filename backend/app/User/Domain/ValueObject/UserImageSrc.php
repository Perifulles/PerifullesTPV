<?php

namespace App\User\Domain\ValueObject;

class UserImageSrc
{
    private ?string $value;

    private function __construct(?string $value)
    {
        if ($value === null) {
            $this->value = null;
            return;
        }

        $normalized = trim($value);
        if ($normalized === '') {
            throw new \InvalidArgumentException('User image source cannot be empty when provided.');
        }

        $this->value = $normalized;
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