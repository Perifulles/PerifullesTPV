<?php

namespace App\Restaurant\Domain\Entity;

use App\Shared\Domain\ValueObject\DomainDateTime;
use App\Shared\Domain\ValueObject\Email;
use App\Shared\Domain\ValueObject\Uuid;
use App\Shared\Domain\ValueObject\PasswordHash;
use App\Restaurant\Domain\ValueObject\TaxId;

class Restaurant{


    private function __construct(
        private Uuid $id,
        private string $name,
        private string $legalName,
        private TaxId $taxId,
        private Email $email,
        private PasswordHash $passwordHash,
        private DomainDateTime $createdAt,
        private DomainDateTime $updatedAt,
    ){}

    public static function dddCreate(
        string $name,
        string $legalName,
        TaxId $taxId,
        Email $email,
        PasswordHash $passwordHash
    ): self {
        $now = DomainDateTime::now();

        return new self(
            Uuid::generate(),
            $name,
            $legalName,
            $taxId,
            $email,
            $passwordHash,
            $now,
            $now
        );
    }

    public static function fromPersistence(
        string $id,
        string $name,
        string $legalName,
        string $taxId,
        string $email,
        string $passwordHash,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt
    ): self {
        return new self(
            Uuid::create($id),
            $name,
            $legalName,
            TaxId::create($taxId),
            Email::create($email),
            PasswordHash::create($passwordHash),
            DomainDateTime::create($createdAt),
            DomainDateTime::create($updatedAt)
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function legalName(): string
    {
        return $this->legalName;
    }

    public function taxId(): TaxId
    {
        return $this->taxId;
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
}
