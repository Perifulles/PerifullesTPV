<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\TokenGeneratorInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutController
{
    public function __construct(
        private readonly TokenGeneratorInterface $tokenGenerator,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->tokenGenerator->revoke(
            Uuid::create($request->user()->uuid),
        );

        return new JsonResponse(null, 204);
    }
}