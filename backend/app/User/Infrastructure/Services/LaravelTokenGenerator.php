<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Services;

use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\TokenGeneratorInterface;
use Illuminate\Support\Str;

final class LaravelTokenGenerator implements TokenGeneratorInterface
{
    public function generate(Uuid $userId): string
    {
        return hash('sha256', $userId->value() . '|' . Str::random(64) . '|' . microtime(true));
    }
}
