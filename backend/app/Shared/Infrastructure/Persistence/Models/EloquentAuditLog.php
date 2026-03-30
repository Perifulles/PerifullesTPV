<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class EloquentAuditLog extends Model
{
    protected $table = 'audit_logs';

    public $timestamps = false;

    const CREATED_AT = 'created_at';

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'entity_type',
        'entity_uuid',
        'action',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];
}