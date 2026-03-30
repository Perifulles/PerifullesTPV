<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\GetUser\GetUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class GetUserController
{
    public function __construct(
        private readonly GetUser $getUser,
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        try {
            $response = ($this->getUser)($uuid);
        } catch (Throwable) {
            return new JsonResponse(['message' => 'User not found.'], 404);
        }

        return new JsonResponse($response->toArray(), 200);
    }
}