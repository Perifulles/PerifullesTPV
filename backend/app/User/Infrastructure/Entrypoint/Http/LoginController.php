<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Entrypoint\Http;

use App\User\Application\LoginUser\LoginUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LoginController
{
    public function __construct(
        private readonly LoginUser $loginUser,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $restaurantUuid = $request->header('X-Restaurant-Uuid', '');

        \Illuminate\Support\Facades\Log::info('Controller reached', [
            'email'          => $validated['email'],
            'restaurantUuid' => $restaurantUuid,
        ]);

        try {
            $response = ($this->loginUser)(
                email: $validated['email'],
                password: $validated['password'],
                restaurantId: $restaurantUuid,
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Login error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return new JsonResponse(['message' => 'Invalid credentials.'], 401);
        }

        return new JsonResponse($response->toArray(), 200);
    }
}