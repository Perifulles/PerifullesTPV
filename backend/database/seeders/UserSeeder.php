<?php

namespace Database\Seeders;

use App\User\Infrastructure\Persistence\Models\EloquentUser;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $restaurant = EloquentRestaurant::first();

        EloquentUser::create([
            'uuid'       => Str::uuid()->toString(),
            'role'       => 'admin',
            'name'       => 'Admin',
            'email'      => 'admin@tpv.com',
            'password'   => Hash::make('password'),
            'restaurant_id' => $restaurant->id,
        ]);

        for ($i = 1; $i <= 3; $i++) {
            EloquentUser::create([
                'uuid'       => Str::uuid(),
                'role' => 'operator',
                'name'       => "Camarero $i",
                'email'      => "camarero$i@tpv.com",
                'password'   => Hash::make('password'),
                'restaurant_id' => $restaurant->id,
            ]);
        }
    }
}
