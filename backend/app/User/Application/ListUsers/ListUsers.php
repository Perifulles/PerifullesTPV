<?php

declare(strict_types=1);

namespace App\User\Application\ListUsers;

use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Interfaces\UserRepositoryInterface;

final class ListUsers
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function __invoke(string $restaurantUuid): ListUsersResponse
    {
        $restaurantId = Uuid::create($restaurantUuid);

        $users = $this->userRepository->findAllByRestaurant($restaurantId);

        return ListUsersResponse::create($users);
    }
}
