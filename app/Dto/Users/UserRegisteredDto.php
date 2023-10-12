<?php

namespace App\Dto\Users;

use Spatie\LaravelData\Data;

class UserRegisteredDto extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
    }
}