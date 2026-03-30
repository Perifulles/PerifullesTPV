<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\UpdateUser\UpdateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UpdateUserController
{
    public function __construct(
        private readonly UpdateUser $updateUser,
    ) {}

    public function __invoke(Request $request, string $uuid): JsonResponse
    {
        $validated = $request->validate([
            'name'      => ['sometimes', 'string', 'max:255'],
            'email'     => ['sometimes', 'email', 'max:255'],
            'password'  => ['sometimes', 'string', 'min:6'],
            'role'      => ['sometimes', 'string', 'in:admin,supervisor,operator'],
            'image_src' => ['sometimes', 'nullable', 'string'],
        ]);

        $response = ($this->updateUser)(
            userUuid: $uuid,
            name: $validated['name'] ?? null,
            email: $validated['email'] ?? null,
            plainPassword: $validated['password'] ?? null,
            role: $validated['role'] ?? null,
            imageSrc: array_key_exists('image_src', $validated) ? $validated['image_src'] : null,
            actorUuid: $request->user()->uuid,
        );

        if ($response === null) {
            return new JsonResponse(['message' => 'User not found.'], 404);
        }

        return new JsonResponse($response->toArray(), 200);
    }
}