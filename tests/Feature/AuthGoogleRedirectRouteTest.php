<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthGoogleRedirectRouteTest extends TestCase
{
    use RefreshDatabase;

    public function testRedirectToGoogle()
    {
        $response = $this->get(route('auth.google.redirect'));

        $response->assertStatus(302);
    }
}