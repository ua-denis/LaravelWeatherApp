<?php

namespace App\Contracts;

interface WeatherServiceInterface
{
    public function getWeatherData(float $latitude, float $longitude);
}