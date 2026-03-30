<?php

declare(strict_types=1);

namespace App\User\Application\CreateUser;

use App\Shared\Domain\Interfaces\AuditLoggerInterface;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Domain\ValueObject\PasswordHash;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserRole;

final class CreateUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly AuditLoggerInterface $auditLogger,
    ) {}

    public function __invoke(
        string $restaurantUuid,
        string $name,
        string $email,
        string $plainPassword,
        string $role,
        ?string $pin = null,
        ?string $imageSrc = null,
        ?string $actorUuid = null,
    ): CreateUserResponse {
        $restaurantIdVO = Uuid::create($restaurantUuid);
        $nameVO = UserName::create($name);
        $emailVO = Email::create($email);
        $passwordHashVO = PasswordHash::create($this->passwordHasher->hash($plainPassword));
        $roleVO = UserRole::create($role);

        $user = User::dddCreate(
            $emailVO,
            $nameVO,
            $passwordHashVO,
            $roleVO,
            $restaurantIdVO,
            $imageSrc,
            $pin,
        );

        $this->userRepository->save($user);

        $this->auditLogger->log(
            entityType: 'user',
            entityUuid: $user->uuid()->value(),
            action: 'created',
            oldValues: null,
            newValues: [
                'name'  => $name,
                'email' => $email,
                'role'  => $role,
            ],
            actorUuid: $actorUuid,
            restaurantUuid: $restaurantUuid,
        );

        return CreateUserResponse::create($user);
    }
}