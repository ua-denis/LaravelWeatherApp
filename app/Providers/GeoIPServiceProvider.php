<?php

namespace App\Providers;

use App\Contracts\GeoIPServiceInterface;
use App\Services\GeoIPService;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\ServiceProvider;
use Torann\GeoIP\GeoIP;

class GeoIPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GeoIPServiceInterface::class, function ($app) {
            $config = config('geoip');
            $cacheManager = $app->make(CacheManager::class);
            $geoIP = new GeoIP($config, $cacheManager);
            return new GeoIPService($geoIP);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
