<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\CreateUser\CreateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CreateUserController
{
    public function __construct(
        private readonly CreateUser $createUser,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:6'],
            'role'      => ['required', 'string', 'in:admin,supervisor,operator'],
            'pin'       => ['nullable', 'digits_between:4,6'],
            'image_src' => ['nullable', 'string'],
        ]);

        $restaurantUuid = $request->user()->restaurant->uuid;
        $actorUuid = $request->user()->uuid;

        $response = ($this->createUser)(
            restaurantUuid: $restaurantUuid,
            name: $validated['name'],
            email: $validated['email'],
            plainPassword: $validated['password'],
            role: $validated['role'],
            pin: $validated['pin'] ?? null,
            imageSrc: $validated['image_src'] ?? null,
            actorUuid: $actorUuid,
        );

        return new JsonResponse($response->toArray(), 201);
    }
}
