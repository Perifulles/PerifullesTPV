<?php

namespace App\User\Domain\ValueObject;

class UserRole
{
    private const ALLOWED_ROLES = [
        'admin',
        'supervisor',
        'operator',
    ];

    private string $value;

    private function __construct(string $value)
    {
        $normalized = trim($value);

        if (!in_array($normalized, self::ALLOWED_ROLES, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid user role "%s". Allowed roles are: %s.',
                    $value,
                    implode(', ', self::ALLOWED_ROLES)
                )
            );
        }

        $this->value = $normalized;
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
