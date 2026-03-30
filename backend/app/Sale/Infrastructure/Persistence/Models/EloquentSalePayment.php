<?php

declare(strict_types=1);

namespace App\Sale\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentSalePayment extends Model
{
    protected $table = 'sale_payments';

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'sale_id',
        'payment_method',
        'amount',
        'reference',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(EloquentSale::class, 'sale_id');
    }
}