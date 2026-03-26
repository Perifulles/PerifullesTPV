<?php

declare(strict_types=1);

namespace App\Sale\Infrastructure\Persistence\Models;

use App\Order\Infrastructure\Persistence\Models\EloquentOrder;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EloquentSale extends Model
{
    use SoftDeletes;

    protected $table = 'sales';

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'order_id',
        'user_id',
        'ticket_number',
        'value_date',
        'total',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(EloquentOrder::class, 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }

    public function lines(): HasMany
    {
        return $this->hasMany(EloquentSaleLine::class, 'sale_id');
    }
}