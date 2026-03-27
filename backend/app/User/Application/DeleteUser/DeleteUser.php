<?php

declare(strict_types=1);

namespace App\User\Application\DeleteUser;

use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\UserRepositoryInterface;

final class DeleteUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function __invoke(string $userUuid): void
    {
        $userId = Uuid::create($userUuid);

        $this->userRepository->delete($userId);
    }
}