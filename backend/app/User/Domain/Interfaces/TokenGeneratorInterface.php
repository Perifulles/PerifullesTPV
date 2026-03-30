<?php

declare(strict_types=1);

namespace App\User\Domain\Interfaces;

use App\Shared\Domain\ValueObject\Uuid;

interface TokenGeneratorInterface
{
    public function generate(Uuid $userUuid): string;

    public function revoke(Uuid $userUuid): void;
}