<?php

declare(strict_types=1);

namespace App\Sale\Infrastructure\Persistence\Models;

use App\Order\Infrastructure\Persistence\Models\EloquentOrderLine;
use App\User\Infrastructure\Persistence\Models\EloquentUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class EloquentSaleLine extends Model
{
    use SoftDeletes;

    protected $table = 'sales_lines';

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'sale_id',
        'order_line_id',
        'user_id',
        'quantity',
        'price',
        'tax_percentage',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(EloquentSale::class, 'sale_id');
    }

    public function orderLine(): BelongsTo
    {
        return $this->belongsTo(EloquentOrderLine::class, 'order_line_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id');
    }
}