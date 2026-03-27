<?php

declare(strict_types=1);

namespace App\User\Application\ListUsers;

use App\User\Domain\Entity\User;

final readonly class ListUsersResponse
{
    private function __construct(
        private array $users,
    ) {}

    /**
     * @param User[] $users
     */
    public static function create(array $users): self
    {
        $usersArray = [];

        foreach ($users as $user) {
            $usersArray[] = [
                'uuid' => $user->uuid()->value(),
                'name' => $user->name()->value(),
                'email' => $user->email()->value(),
                'role' => $user->role()->value(),
                'image_src' => $user->imageSrc()->value(),
                'created_at' => $user->createdAt()->format(\DateTimeInterface::ATOM),
                'updated_at' => $user->updatedAt()->format(\DateTimeInterface::ATOM),
            ];
        }

        return new self($usersArray);
    }

    public function toArray(): array
    {
        return $this->users;
    }
}