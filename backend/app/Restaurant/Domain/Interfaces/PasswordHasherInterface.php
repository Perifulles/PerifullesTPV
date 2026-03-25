<?php

namespace App\Restaurant\Domain\Interfaces;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;
}
