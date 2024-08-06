<?php

namespace App\Models;

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $gender,
        public int $age,
        public string $address
    ) {
    }
}