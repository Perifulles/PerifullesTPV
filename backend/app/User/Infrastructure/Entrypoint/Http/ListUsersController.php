<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\ListUsers\ListUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ListUsersController
{
    public function __construct(
        private readonly ListUsers $listUsers,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $restaurantUuid = $request->user()->restaurant->uuid;

        $response = ($this->listUsers)($restaurantUuid);

        return new JsonResponse($response->toArray(), 200);
    }
}