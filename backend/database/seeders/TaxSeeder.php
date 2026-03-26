<?php

namespace Database\Seeders;

use App\Restaurant\Infrastructure\Persistence\Models\EloquentRestaurant;
use App\Tax\Infrastructure\Persistence\Models\EloquentTax;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaxSeeder extends Seeder
{
	public function run(): void
	{
		$restaurant = EloquentRestaurant::first();

		if (!$restaurant) {
			return;
		}

		$taxes = [
			['name' => 'IVA General', 'percentage' => 21],
			['name' => 'IVA Reducido', 'percentage' => 10],
			['name' => 'IVA Superreducido', 'percentage' => 4],
			['name' => 'Sin IVA', 'percentage' => 0],
		];

		foreach ($taxes as $tax) {
			EloquentTax::create([
				'uuid' => Str::uuid()->toString(),
				'name' => $tax['name'],
				'percentage' => $tax['percentage'],
				'restaurant_id' => $restaurant->id,
			]);
		}
	}
}
