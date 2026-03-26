<?php

namespace Database\Seeders;

use App\Family\Infrastructure\Persistence\Models\EloquentFamily;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        $restaurant = EloquentRestaurant::first();

        $tipos = ['Bebidas', 'Comida', 'Postres', 'Tapas', 'Licores'];

        foreach ($tipos as $tipo) {
            EloquentFamily::create([
                'uuid'          => Str::uuid()->toString(),
                'name'          => $tipo,
                'active'        => true,
                'restaurant_id' => $restaurant->id,
            ]);
        }
    }
}