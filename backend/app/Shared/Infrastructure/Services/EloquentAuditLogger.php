<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Services;

use App\Shared\Domain\Interfaces\AuditLoggerInterface;
use App\Shared\Infrastructure\Persistence\Models\EloquentAuditLog;
use Illuminate\Support\Facades\DB;

class EloquentAuditLogger implements AuditLoggerInterface
{
    public function log(
        string $entityType,
        string $entityUuid,
        string $action,
        ?array $oldValues,
        ?array $newValues,
        ?string $actorUuid,
        string $restaurantUuid,
    ): void {
        try {
            $restaurantId = DB::table('restaurants')
                ->where('uuid', $restaurantUuid)
                ->value('id');

            if ($restaurantId === null) {
                return;
            }

            $userId = null;

            if ($actorUuid !== null) {
                $userId = DB::table('users')
                    ->where('uuid', $actorUuid)
                    ->value('id');
            }

            EloquentAuditLog::create([
                'restaurant_id' => $restaurantId,
                'user_id'       => $userId,
                'entity_type'   => $entityType,
                'entity_uuid'   => $entityUuid,
                'action'        => $action,
                'old_values'    => $oldValues,
                'new_values'    => $newValues,
            ]);
        } catch (\Throwable) {
            // El audit log nunca bloquea la operación principal.
            // Si falla, falla en silencio.
        }
    }
}