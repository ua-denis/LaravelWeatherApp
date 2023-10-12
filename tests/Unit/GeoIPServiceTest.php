<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Services\GeoIPService;
use Torann\GeoIP\GeoIP;

class GeoIPServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetLocationWithValidIpAddress()
    {
        $ipAddress = '127.0.0.1';
        $mockLocation = (object)[
            'ip' => '127.0.0.0',
            'iso_code' => 'US',
            'country' => 'United States',
            'city' => 'New Haven',
            'state' => 'CT',
            'state_name' => 'Connecticut',
            'postal_code' => '06510',
            'lat' => 41.31,
            'lon' => -72.92,
            'timezone' => 'America/New_York',
            'continent' => 'NA',
            'default' => true,
            'currency' => 'USD',
        ];

        $geoIPMock = Mockery::mock(GeoIP::class);
        $geoIPMock->shouldReceive('getLocation')
            ->with($ipAddress)
            ->once()
            ->andReturn($mockLocation);

        $geoIPService = new GeoIPService($geoIPMock);
        $location = $geoIPService->getLocation($ipAddress);

        $this->assertEquals($mockLocation, $location);
    }

    public function testGetLocationWithInvalidIpAddress()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid IP address: invalid');

        $geoIPMock = Mockery::mock(GeoIP::class);

        $geoIPService = new GeoIPService($geoIPMock);
        $geoIPService->getLocation('invalid');
    }
}