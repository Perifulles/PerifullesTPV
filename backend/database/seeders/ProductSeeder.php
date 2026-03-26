<?php

namespace Database\Seeders;

use App\Family\Infrastructure\Persistence\Models\EloquentFamily;
use App\Product\Infrastructure\Persistence\Models\EloquentProduct;
use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Tax\Infrastructure\Persistence\Models\EloquentTax;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $restaurant = EloquentRestaurant::first();

        if (!$restaurant) {
            return;
        }

        $families = EloquentFamily::where('restaurant_id', $restaurant->id)
            ->get()
            ->keyBy('name');

        $taxes = EloquentTax::where('restaurant_id', $restaurant->id)
            ->get()
            ->keyBy('name');

        if ($families->isEmpty() || $taxes->isEmpty()) {
            return;
        }

        $products = [
            ['name' => 'Coca-Cola 33cl', 'family' => 'Bebidas', 'tax' => 'IVA General', 'price' => 250, 'stock' => 120],
            ['name' => 'Agua mineral 50cl', 'family' => 'Bebidas', 'tax' => 'IVA Reducido', 'price' => 150, 'stock' => 150],
            ['name' => 'Tarta de queso', 'family' => 'Postres', 'tax' => 'IVA Reducido', 'price' => 480, 'stock' => 40],
            ['name' => 'Flan casero', 'family' => 'Postres', 'tax' => 'IVA Reducido', 'price' => 380, 'stock' => 35],
            ['name' => 'Patatas bravas', 'family' => 'Tapas', 'tax' => 'IVA Reducido', 'price' => 650, 'stock' => 60],
            ['name' => 'Croquetas de jamon', 'family' => 'Tapas', 'tax' => 'IVA Reducido', 'price' => 720, 'stock' => 55],
            ['name' => 'Hamburguesa completa', 'family' => 'Comida', 'tax' => 'IVA Reducido', 'price' => 1150, 'stock' => 45],
            ['name' => 'Ensalada cesar', 'family' => 'Comida', 'tax' => 'IVA Reducido', 'price' => 890, 'stock' => 50],
            ['name' => 'Vino tinto crianza copa', 'family' => 'Licores', 'tax' => 'IVA General', 'price' => 420, 'stock' => 70],
            ['name' => 'Licor de hierbas', 'family' => 'Licores', 'tax' => 'IVA General', 'price' => 390, 'stock' => 65],
        ];

        foreach ($products as $product) {
            $family = $families->get($product['family']);
            $tax = $taxes->get($product['tax']);

            if (!$family || !$tax) {
                continue;
            }

            EloquentProduct::create([
                'uuid' => Str::uuid()->toString(),
                'restaurant_id' => $restaurant->id,
                'family_id' => $family->id,
                'tax_id' => $tax->id,
                'image_src' => null,
                'name' => $product['name'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'active' => true,
            ]);
        }
    }
}