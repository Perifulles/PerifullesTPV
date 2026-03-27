<?php

declare(strict_types=1);

namespace App\User\Application\GetUser;

use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\UserRepositoryInterface;

final class GetUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function __invoke(string $userUuid): ?GetUserResponse
    {
        $userId = Uuid::create($userUuid);

        $user = $this->userRepository->findByUuid($userId);

        if ($user === null) {
            return null;
        }

        return GetUserResponse::create($user);
    }
}