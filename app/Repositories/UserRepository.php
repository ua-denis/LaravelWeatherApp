<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findByProvider($provider_id)
    {
        return User::where('provider_id', $provider_id)->first();
    }
}