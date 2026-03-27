<?php

declare(strict_types=1);

namespace App\User\Application\UpdateUser;

use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
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
    ) {}

    public function __invoke(
        string $userUuid,
        ?string $name = null,
        ?string $email = null,
        ?string $plainPassword = null,
        ?string $role = null,
        ?string $imageSrc = null,
    ): ?UpdateUserResponse {
        $user = $this->userRepository->findByUuid(Uuid::create($userUuid));

        if ($user === null) {
            return null;
        }


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

        return UpdateUserResponse::create($user);
    }
}