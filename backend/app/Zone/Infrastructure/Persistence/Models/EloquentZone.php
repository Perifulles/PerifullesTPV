<?php

declare(strict_types=1);

namespace App\Zone\Infrastructure\Persistence\Models;

use App\Table\Infrastructure\Persistence\Models\EloquentTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EloquentZone extends Model
{
    use SoftDeletes;

    protected $table = 'zones';

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'name',
    ];

    public function tables(): HasMany
    {
        return $this->hasMany(EloquentTable::class, 'zone_id');
    }
}