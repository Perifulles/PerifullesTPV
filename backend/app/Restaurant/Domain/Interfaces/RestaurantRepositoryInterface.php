<?php

namespace App\Restaurant\Domain\Interfaces;

use App\Restaurant\Domain\Entity\Restaurant;

interface RestaurantRepositoryInterface
{
    public function save(Restaurant $restaurant): void;
    public function findById(string $id): ?Restaurant;
}