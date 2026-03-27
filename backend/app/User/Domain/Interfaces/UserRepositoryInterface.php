<?php

declare(strict_types=1);

namespace App\User\Domain\Interfaces;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function findByUuid(Uuid $uuid): ?User;

    public function findByEmail(Email $email, Uuid $restaurantId): ?User;

    public function findAllByRestaurant(Uuid $restaurantId): array;

    public function update(User $user): void;

    public function delete(Uuid $uuid): void;
}