<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Persistence\Models;

use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class EloquentUser extends Authenticatable
{
    use HasApiTokens;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'uuid',
        'restaurant_id',
        'role',
        'image_src',
        'name',
        'email',
        'password',
        'pin',
    ];

    protected $hidden = [
        'password',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(EloquentRestaurant::class, 'restaurant_id');
    }
}