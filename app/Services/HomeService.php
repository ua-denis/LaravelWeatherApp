<?php

namespace App\Services;

use App\Contracts\GeoIPServiceInterface;
use App\Contracts\WeatherServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeService
{
    private WeatherServiceInterface $weatherService;
    private GeoIPServiceInterface  $geoService;
    private Request $request;

    public function __construct(
        WeatherServiceInterface $weatherService,
        GeoIPServiceInterface  $geoService,
        Request $request
    ) {
        $this->weatherService = $weatherService;
        $this->geoService = $geoService;
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function getData(): array
    {
        $data = [];
        if (Auth::check()) {
            $ipAddress = $this->request->ip();
            $location = $this->geoService->getLocation($ipAddress);
            $weatherData = $this->weatherService->getWeatherData($location->lat, $location->lon);
            $data = [
                'user' => Auth::user(),
                'main' => $weatherData['main'] ?? [],
            ];
        }
        return $data;
    }
}