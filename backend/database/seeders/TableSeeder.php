<?php

namespace Database\Seeders;


use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Table\Infrastructure\Persistence\Models\EloquentTable;
use App\Zone\Infrastructure\Persistence\Models\EloquentZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $restaurant = EloquentRestaurant::first();

        if (!$restaurant) {
            return;
        }

        $zones = EloquentZone::where('restaurant_id', $restaurant->id)
            ->get()
            ->keyBy('name');


        $tablesPerZone = [
            'Terraza' => 5,
            'Salón' => 10,
            'Barra' => 3,
            'Zona VIP' => 2,
        ];

        foreach ($tablesPerZone as $zoneName => $tableCount) {
            $zone = $zones->get($zoneName);

            if (!$zone) {
                continue;
            }

            for ($i = 1; $i <= $tableCount; $i++) {
                EloquentTable::create([
                    'uuid' => Str::uuid()->toString(),
                    'name' => "$zoneName - Mesa $i",
                    'restaurant_id' => $restaurant->id,
                    'zone_id' => $zone->id, 
                ]);
            }
        }
    }
}
