<?php

declare(strict_types=1);

namespace App\User\Application\UpdateUser;

use App\Shared\Domain\Interfaces\AuditLoggerInterface;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\PasswordHasherInterface;
use App\User\Domain\Interfaces\UserRepositoryInterface;
use App\User\Application\UpdateUser\UpdateUserResponse;
use App\User\Domain\ValueObject\PasswordHash;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserRole;

final class UpdateUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly AuditLoggerInterface $auditLogger,
    ) {}

    public function __invoke(
        string $userUuid,
        ?string $name = null,
        ?string $email = null,
        ?string $plainPassword = null,
        ?string $role = null,
        ?string $imageSrc = null,
        ?string $actorUuid = null,
    ): ?UpdateUserResponse {
        $user = $this->userRepository->findByUuid(Uuid::create($userUuid));

        if ($user === null) {
            return null;
        }

        $oldValues = $this->toAuditValues($user);

        if ($name !== null) {
            $user->updateName(UserName::create($name));
        }

        if ($email !== null) {
            $user->updateEmail(Email::create($email));
        }

        if ($plainPassword !== null) {
            $hashedPassword = PasswordHash::create($this->passwordHasher->hash($plainPassword));
            $user->updatePassword($hashedPassword);
        }

        if ($role !== null) {
            $user->updateRole(UserRole::create($role));
        }

        if ($imageSrc !== null) {
            $user->updateImageSrc($imageSrc);
        }

        $this->userRepository->update($user);

        $response = UpdateUserResponse::create($user);

        $this->auditLogger->log(
            'user',
            $user->uuid()->value(),
            'updated',
            $oldValues,
            [
                'name'  => $user->name()->value(),
                'email' => $user->email()->value(),
                'role'  => $user->role()->value(),
            ],
            $actorUuid,
            $user->restaurantId()->value(),
        );

        return $response;
    }

    private function toAuditValues(User $user): array
    {
        return [
            'uuid' => $user->uuid()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'role' => $user->role()->value(),
            'image_src' => $user->imageSrc()?->value(),
            'created_at' => $user->createdAt()->format(\DateTimeInterface::ATOM),
            'updated_at' => $user->updatedAt()->format(\DateTimeInterface::ATOM),
        ];
    }
}
