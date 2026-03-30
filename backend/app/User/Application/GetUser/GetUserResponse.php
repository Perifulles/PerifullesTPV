<?php

declare(strict_types=1);

namespace App\User\Application\GetUser;

use App\User\Domain\Entity\User;

final readonly class GetUserResponse
{
    private function __construct(
        private array $user,
    ) {}

    public static function create(User $user): self
    {
        $userArray = [
            'uuid' => $user->uuid()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'role' => $user->role()->value(),
            'image_src' => $user->imageSrc()?->value(),
            'created_at' => $user->createdAt()->format(\DateTimeInterface::ATOM),
            'updated_at' => $user->updatedAt()->format(\DateTimeInterface::ATOM),
        ];

        return new self($userArray);
    }

    public function toArray(): array
    {
        return $this->user;
    }
}
