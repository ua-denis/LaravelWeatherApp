<?php

namespace Tests\Unit;

use App\Contracts\GeoIPServiceInterface;
use App\Contracts\WeatherServiceInterface;
use App\Models\User;
use App\Services\HomeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class HomeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $weatherServiceMock;
    protected $geoServiceMock;
    protected $requestMock;
    protected $homeService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->weatherServiceMock = $this->createMock(WeatherServiceInterface::class);
        $this->geoServiceMock = $this->createMock(GeoIPServiceInterface::class);
        $this->requestMock = $this->createMock(Request::class);
        $this->homeService = new HomeService($this->weatherServiceMock, $this->geoServiceMock, $this->requestMock);
    }

    public function testGetDataReturnsEmptyArrayWhenNotAuthenticated()
    {
        Auth::shouldReceive('check')->once()->andReturn(false);

        $data = $this->homeService->getData();

        $this->assertEmpty($data);
    }

    public function testGetDataReturnsUserDataAndWeatherDataWhenAuthenticated()
    {
        $user = User::factory()->create();
        Auth::shouldReceive('check')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $ipAddress = '123.123.123.123';
        $mock = Mockery::mock(Request::class);
        $mock->shouldReceive('ip')->once()->andReturn($ipAddress);
        $this->app->instance(Request::class, $mock);

        $locationMock = (object)[
            'lat' => 40.7128,
            'lon' => -74.0060,
        ];
        $this->geoServiceMock->expects($this->once())
            ->method('getLocation')
            ->with($ipAddress)
            ->willReturn($locationMock);

        $weatherDataMock = [
            'main' => ['temp' => 295.15],
        ];
        $this->weatherServiceMock->expects($this->once())
            ->method('getWeatherData')
            ->with($locationMock->lat, $locationMock->lon)
            ->willReturn($weatherDataMock);

        $homeService = new HomeService($this->weatherServiceMock, $this->geoServiceMock, $mock);

        $data = $homeService->getData();

        $this->assertNotEmpty($data);
        $this->assertSame($user, $data['user']);
        $this->assertSame($weatherDataMock['main'], $data['main']);
    }

}