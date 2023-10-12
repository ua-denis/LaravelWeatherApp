<?php

namespace Tests\Unit;

use App\Services\WeatherService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;


class WeatherServiceTest extends TestCase
{
    protected $weatherService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->weatherService = new WeatherService();
    }

    public function testItFetchesWeatherDataFromAPIAndCachesIt()
    {
        Http::fake([
            'api.openweathermap.org/*' => Http::response(['weather' => 'sunny'], 200),
        ]);

        $latitude = 40.7128;
        $longitude = -74.0060;
        $weatherService = new WeatherService();

        $weatherData = $weatherService->getWeatherData($latitude, $longitude);

        $this->assertNotEmpty($weatherData);
        $this->assertSame('sunny', $weatherData['weather']);
        $this->assertSame(1, Redis::exists("weather.$latitude.$longitude"));
    }

    public function testItReturnsCachedDataIfAvailable()
    {
        $latitude = 35.6895;
        $longitude = 139.6917;

        $cachedData = ['weather' => 'cloudy'];
        Redis::set("weather.$latitude.$longitude", json_encode($cachedData));

        $weatherData = $this->weatherService->getWeatherData($latitude, $longitude);

        $this->assertSame('cloudy', $weatherData['weather']);
    }
}