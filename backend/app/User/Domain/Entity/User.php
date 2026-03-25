<?php

namespace App\User\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\ValueObject\PasswordHash;
use App\User\Domain\ValueObject\UserName;

class User
{
    private function __construct(
        private Uuid $id,
        private string $role,
        private ?string $imageSrc,
        private UserName $name,
        private Email $email,
        private PasswordHash $passwordHash,
        private ?string $pin,
        private string $restaurantId,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ) {}

    public static function dddCreate(
    Email $email, 
    UserName $name, 
    PasswordHash $passwordHash,
    string $role,
    string $restaurantId,
    ?string $imageSrc = null,
    ?string $pin = null

    ): self {

        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $role,
            $imageSrc,
            $name,
            $email,
            $passwordHash,
            $pin,
            $restaurantId,
            $now,
            $now,
        );
    }

    public static function fromPersistence(
        string $id,
        string $role,
        ?string $imageSrc,
        string $name,
        string $email,
        string $passwordHash,
        ?string $pin,
        string $restaurantId,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            Uuid::create($id),
            $role,
            $imageSrc,
            UserName::create($name),
            Email::create($email),
            PasswordHash::create($passwordHash),
            $pin,
            $restaurantId,
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt),
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name->value();
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function passwordHash(): string
    {
        return $this->passwordHash->value();
    }

    public function createdAt(): DomainDateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): DomainDateTime
    {
        return $this->updatedAt;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function imageSrc(): ?string
    {
        return $this->imageSrc;
    }

    public function pin(): ?string
    {
        return $this->pin;
    }

    public function restaurantId(): string
    {
        return $this->restaurantId;
    }
}
