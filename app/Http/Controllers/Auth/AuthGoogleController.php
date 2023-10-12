<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\AuthGoogleService;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class AuthGoogleController extends Controller
{
    public function __construct(private AuthGoogleService $authGoogleService)
    {}
    public function redirectToGoogle(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return $this->authGoogleService->redirectToGoogle();
    }

    public function handleGoogleCallback(): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $this->authGoogleService->handleGoogleCallback();
        return redirect(RouteServiceProvider::HOME);
    }
}
