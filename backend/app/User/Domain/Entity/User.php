<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\ValueObject\Pin;
use App\User\Domain\ValueObject\PasswordHash;
use App\User\Domain\ValueObject\UserImageSrc;
use App\User\Domain\ValueObject\UserName;
use App\User\Domain\ValueObject\UserRole;

final class User
{
    private function __construct(
        private Uuid $uuid,
        private UserRole $role,
        private UserImageSrc $imageSrc,
        private UserName $name,
        private Email $email,
        private PasswordHash $passwordHash,
        private Pin $pin,
        private Uuid $restaurantId,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(
        Email $email,
        UserName $name,
        PasswordHash $passwordHash,
        UserRole $role,
        Uuid $restaurantId,
        ?string $imageSrc = null,
        ?string $pin = null
    ): self {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $role,
            UserImageSrc::create($imageSrc),
            $name,
            $email,
            $passwordHash,
            Pin::create($pin),
            $restaurantId,
            $now,
            $now,
        );
    }

    public static function fromPrimitives(
        string $uuid,
        string $role,
        ?string $imageSrc,
        string $name,
        string $email,
        string $passwordHash,
        ?string $pin,
        string $restaurantId,
        string $createdAt,
        string $updatedAt,
    ): self {
        return new self(
            Uuid::create($uuid),
            UserRole::create($role),
            UserImageSrc::create($imageSrc),
            UserName::create($name),
            Email::create($email),
            PasswordHash::create($passwordHash),
            Pin::create($pin),
            Uuid::create($restaurantId),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function updateName(UserName $name): void
    {
        $this->name = $name;
        $this->touch();
    }

    public function updateEmail(Email $email): void
    {
        $this->email = $email;
        $this->touch();
    }

    public function updateRole(UserRole $role): void
    {
        $this->role = $role;
        $this->touch();
    }

    public function updatePassword(PasswordHash $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
        $this->touch();
    }

    public function updateImageSrc(?string $imageSrc): void
    {
        $this->imageSrc = UserImageSrc::create($imageSrc);
        $this->touch();
    }

    private function touch(): void
    {
        $this->updatedAt = DomainDateTime::now();
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function imageSrc(): UserImageSrc
    {
        return $this->imageSrc;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function passwordHash(): PasswordHash
    {
        return $this->passwordHash;
    }

    public function createdAt(): DomainDateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DomainDateTime
    {
        return $this->updatedAt;
    }

    public function pin(): Pin
    {
        return $this->pin;
    }

    public function restaurantId(): Uuid
    {
        return $this->restaurantId;
    }
}