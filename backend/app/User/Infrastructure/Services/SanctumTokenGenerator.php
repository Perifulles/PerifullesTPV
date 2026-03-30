<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Services;

use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\TokenGeneratorInterface;
use App\User\Infrastructure\Persistence\Models\EloquentUser;

final class SanctumTokenGenerator implements TokenGeneratorInterface
{
    public function generate(Uuid $userUuid): string
    {
        $eloquentUser = EloquentUser::where('uuid', $userUuid->value())->firstOrFail();

        return $eloquentUser->createToken('auth-token')->plainTextToken;
    }

    public function revoke(Uuid $userUuid): void
    {
        $eloquentUser = EloquentUser::where('uuid', $userUuid->value())->first();

        if ($eloquentUser === null) {
            return;
        }

        $eloquentUser->tokens()->delete();
    }
}