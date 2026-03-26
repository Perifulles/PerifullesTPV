<?php

namespace Database\Seeders;

use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            EloquentRestaurant::create([
                'uuid' => Str::uuid(),
                'name' => 'Restaurant' . $i,
                'legal_name' => 'Restaurant ' . $i . ' S.A.',
                'tax_id' => '1234567890',
                'email' => 'restaurant' . $i . '@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
