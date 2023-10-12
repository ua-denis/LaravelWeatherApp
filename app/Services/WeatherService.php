<?php

namespace App\Services;

use App\Contracts\WeatherServiceInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use JsonException;

class WeatherService implements WeatherServiceInterface
{
    private mixed $weatherApiKey;
    private string $weatherApiEndpoint;
    public function __construct()
    {
        $this->weatherApiKey = config('services.weather_api.key');
        $this->weatherApiEndpoint = config('services.weather_api.endpoint');
    }

    /**
     * @throws JsonException
     */
    public function getWeatherData(float $latitude, float $longitude)
    {
        $this->validateCoordinates($latitude, $longitude);

        $cacheKey = "weather.$latitude.$longitude";

        if (Redis::exists($cacheKey)) {
            return json_decode(Redis::get($cacheKey), true, 512, JSON_THROW_ON_ERROR);
        }

        try {
            $weatherData = $this->fetchWeatherFromAPI($latitude, $longitude);
            Redis::setex($cacheKey, 1800, json_encode($weatherData, JSON_THROW_ON_ERROR));

            return $weatherData;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }

    private function fetchWeatherFromAPI($latitude, $longitude)
    {
        return Http::get(
            "{$this->weatherApiEndpoint}?lat={$latitude}&lon={$longitude}&appid={$this->weatherApiKey}"
        )->json();
    }

    private function validateCoordinates($latitude, $longitude): void
    {
        if (!is_numeric($latitude) || !is_numeric($longitude)) {
            throw new \InvalidArgumentException('Invalid latitude or longitude');
        }
    }
}