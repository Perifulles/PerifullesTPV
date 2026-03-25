<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('role');
            $table->string('image_src')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('pin')->nullable();
            $table->foreignId('restaurant_id')->constrained('restaurants');

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
