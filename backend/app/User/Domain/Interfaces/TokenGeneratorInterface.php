<?php

declare(strict_types=1);

namespace App\User\Domain\Interfaces;

use App\Shared\Domain\ValueObject\Uuid;

interface TokenGeneratorInterface
{
    public function generate(Uuid $userId): string;
}
