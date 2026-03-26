<?php

namespace Database\Seeders;

use App\Zone\Infrastructure\Persistence\Models\EloquentZone;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ZoneSeeder extends Seeder
{
    public function run(): void
    {
        $restaurant = EloquentRestaurant::first();

        if (!$restaurant) {
            return;
        }


        $zones = ['Terraza', 'Salón', 'Barra', 'Zona VIP'];

        foreach ($zones as $zone) {
            EloquentZone::create([
                'uuid' => Str::uuid()->toString(),
                'name' => $zone,
                'restaurant_id' => $restaurant->id,
            ]);
        }

    }
}