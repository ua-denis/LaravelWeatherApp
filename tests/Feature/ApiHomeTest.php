<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_home_access()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->getJson(route('api.home'));

        $response->assertOk()
            ->assertJson([]);
    }

    public function test_unauthenticated_home_access()
    {
        $response = $this->getJson(route('api.home'));

        $response->assertStatus(401);
    }
}


