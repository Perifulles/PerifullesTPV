<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Services;

use App\User\Domain\Interfaces\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

final class LaravelPasswordHasher implements PasswordHasherInterface
{
    public function hash(string $plainPassword): string
    {
        return Hash::make($plainPassword);
    }

    public function verify(string $plainPassword, string $hashedPassword): bool
    {
        return Hash::check($plainPassword, $hashedPassword);
    }
}