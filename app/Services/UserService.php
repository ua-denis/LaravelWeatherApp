<?php

namespace App\Services;

use App\Dto\Users\UserRegisteredDto;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(UserRegisteredDto $user)
    {
        return $this->userRepository->create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => Hash::make($user->password),
        ]);
    }
}