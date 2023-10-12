<?php

namespace Tests\Unit;

use App\Services\AuthGoogleService;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use Laravel\Socialite\Two\User as SocialiteUser;

class AuthGoogleServiceTest extends TestCase
{
    use RefreshDatabase;

    private $userRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
    }

    public function testRedirectToGoogle()
    {
        $socialiteProviderMock = Mockery::mock(Provider::class);
        $socialiteProviderMock->shouldReceive('redirect')->once()->andReturn(new RedirectResponse(url('/')));

        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($socialiteProviderMock);

        $authGoogleService = new AuthGoogleService();
        $authGoogleService->redirectToGoogle();
    }

    public function testHandleGoogleCallback()
    {
        $socialiteProviderMock = Mockery::mock(Provider::class);

        $userMock = Mockery::mock(SocialiteUser::class);
        $userMock->shouldReceive('getId')->twice()->andReturn('1234567890');  // Adjusted this line
        $userMock->shouldReceive('getName')->once()->andReturn('John Doe');
        $userMock->shouldReceive('getEmail')->once()->andReturn('john.doe@example.com');

        $socialiteProviderMock->shouldReceive('user')->once()->andReturn($userMock);
        Socialite::shouldReceive('driver')->with('google')->once()->andReturn($socialiteProviderMock);

        $authGoogleService = new AuthGoogleService();
        $result = $authGoogleService->handleGoogleCallback();

        $this->assertTrue($result);
    }

}