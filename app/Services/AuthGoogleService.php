<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthGoogleService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function redirectToGoogle(): RedirectResponse|\Illuminate\Http\RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): bool
    {
        $user = Socialite::driver('google')->user();
        $localUser = $this->findOrCreateUser($user);

        Auth::login($localUser);

        return true;
    }

    protected function findOrCreateUser($googleUser)
    {
        $user = $this->userRepository->findByProvider($googleUser->getId());

        if ($user) {
            return $user;
        }

        return $this->userRepository->create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'provider_id' => $googleUser->getId(),
            'provider' => 'google',
            'password' => bcrypt(Str::random(16))
        ]);
    }

}