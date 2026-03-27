<?php

namespace App\Shared\Domain\ValueObject;

class DomainDateTime
{
    private \DateTimeImmutable $value;

    private function __construct(?\DateTimeImmutable $value = null)
    {
        $this->value = $value ?? new \DateTimeImmutable;
    }

    public static function create(\DateTimeImmutable|string|null $value = null): self
    {
        if (is_string($value)) {
            return new self(new \DateTimeImmutable($value));
        }

        return new self($value);
    }

    public static function now(): self
    {
        return self::create(new \DateTimeImmutable);
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }

    public function format(string $format): string
    {
        return $this->value->format($format);
    }
}
