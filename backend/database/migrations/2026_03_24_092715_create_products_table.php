<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('family_id')->constrained('families');
            $table->foreignId('tax_id')->constrained('taxes');
            $table->foreignId('restaurant_id')->constrained('restaurants');
            $table->string('image_src')->nullable();
            $table->string('name');
            $table->integer('price');
            $table->integer('stock');
            $table->boolean('active');

            
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
