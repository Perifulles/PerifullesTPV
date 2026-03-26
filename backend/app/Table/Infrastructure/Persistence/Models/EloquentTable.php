<?php

declare(strict_types=1);

namespace App\Table\Infrastructure\Persistence\Models;

use App\Zone\Infrastructure\Persistence\Models\EloquentZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EloquentTable extends Model
{
    use SoftDeletes;

    protected $table = 'tables';

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'zone_id',
        'name',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(EloquentZone::class, 'zone_id');
    }
}