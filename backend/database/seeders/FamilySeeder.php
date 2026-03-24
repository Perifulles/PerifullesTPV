<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Bebidas', 'Comida', 'Postres', 'Tapas', 'Licores'];

        foreach ($tipos as $tipo) {

            DB::table('families')->insert([
                [
                    'uuid' => Str::uuid(),
                    'name' => $tipo,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        };
    }
}
