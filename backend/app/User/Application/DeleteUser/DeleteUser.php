<?php

declare(strict_types=1);

namespace App\User\Application\DeleteUser;

use App\Shared\Domain\Interfaces\AuditLoggerInterface;
use App\Shared\Domain\ValueObject\Uuid;
use App\User\Domain\Entity\User;
use App\User\Domain\Interfaces\UserRepositoryInterface;

final class DeleteUser
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AuditLoggerInterface $auditLogger,
    ) {}

    public function __invoke(string $userUuid, ?string $actorUuid, string $restaurantUuid): void
    {
        $userId = Uuid::create($userUuid);
        $user = $this->userRepository->findByUuid($userId);

        if ($user === null) {
            return;
        }

        $oldValues = $this->toAuditValues($user);

        $this->userRepository->delete($userId);

        $this->auditLogger->log(
            'user',
            $userUuid,
            'delete',
            $oldValues,
            null,
            $actorUuid,
            $restaurantUuid,
        );
    }

    private function toAuditValues(User $user): array
    {
        return [
            'uuid' => $user->uuid()->value(),
            'name' => $user->name()->value(),
            'email' => $user->email()->value(),
            'role' => $user->role()->value(),
            'image_src' => $user->imageSrc()->value(),
            'created_at' => $user->createdAt()->format(\DateTimeInterface::ATOM),
            'updated_at' => $user->updatedAt()->format(\DateTimeInterface::ATOM),
        ];
    }
}