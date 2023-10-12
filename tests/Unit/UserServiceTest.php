<?php

namespace Tests\Unit;

use App\Dto\Users\UserRegisteredDto;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $userRepositoryMock = $this->createMock(UserRepository::class);

        $userDto = new UserRegisteredDto(
            name: 'John',
            email: 'john@example.com',
            password: 'password123'
        );

        Hash::shouldReceive('make')
            ->once()
            ->with($userDto->password)
            ->andReturn('hashed_password');

        $expectedData = [
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => 'hashed_password',
        ];

        $userRepositoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($expectedData))
            ->willReturn(new User);

        $userService = new UserService($userRepositoryMock);

        $user = $userService->create($userDto);

        $this->assertInstanceOf(User::class, $user);
    }
}