<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

interface AuditLoggerInterface
{
    public function log(
        string $entityType,
        string $entityUuid,
        string $action,
        ?array $oldValues,
        ?array $newValues,
        ?string $actorUuid,
        string $restaurantUuid,
    ): void;
}