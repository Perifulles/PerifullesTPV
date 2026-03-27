<?php

namespace Database\Seeders;

use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'La Barra Central',
                'legal_name' => 'La Barra Central Hosteleria S.L.',
                'tax_id' => 'B23456783',
                'email' => 'labarracentral@example.com',
            ],
            [
                'name' => 'Casa Rivera',
                'legal_name' => 'Casa Rivera Restauracion S.L.',
                'tax_id' => 'A12345674',
                'email' => 'casarivera@example.com',
            ],
            [
                'name' => 'El Mercado',
                'legal_name' => 'El Mercado Gourmet S.A.',
                'tax_id' => 'A34567891',
                'email' => 'elmercado@example.com',
            ],
            [
                'name' => 'Mar y Brasa',
                'legal_name' => 'Mar y Brasa Cocina Mediterranea S.L.',
                'tax_id' => 'B45678901',
                'email' => 'marybrasa@example.com',
            ],
            [
                'name' => 'Patio Norte',
                'legal_name' => 'Patio Norte Restaurantes S.L.',
                'tax_id' => 'A56789019',
                'email' => 'pationorte@example.com',
            ],
        ];

        foreach ($restaurants as $restaurant) {
            EloquentRestaurant::create([
                'uuid' => Str::uuid(),
                'name' => $restaurant['name'],
                'legal_name' => $restaurant['legal_name'],
                'tax_id' => $restaurant['tax_id'],
                'email' => $restaurant['email'],
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
