<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\DeleteUser\DeleteUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DeleteUserController
{
    public function __construct(
        private readonly DeleteUser $deleteUser,
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        ($this->deleteUser)(
            userUuid: $uuid,
            actorUuid: $request->user()->uuid,
            restaurantUuid: $request->user()->restaurant->uuid,
        );

        return new JsonResponse(null, 204);
    }
}