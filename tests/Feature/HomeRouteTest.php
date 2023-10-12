<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class HomeRouteTest extends TestCase
{
    public function testHomeRoute()
    {
        $response = $this->get('/home');

        $response->assertStatus(200);

        $route = Route::getRoutes()->match(Request::create('/home', 'GET'));
        $action = $route->getActionName();

        $this->assertEquals('App\Http\Controllers\HomeController', $action);

        $response->assertViewIs('home');
    }

}