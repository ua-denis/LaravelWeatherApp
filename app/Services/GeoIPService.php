<?php

namespace App\Services;

use App\Contracts\GeoIPServiceInterface;
use Torann\GeoIP\GeoIP;

class GeoIPService implements GeoIPServiceInterface
{
    protected $geoIP;

    public function __construct(GeoIP $geoIP)
    {
        $this->geoIP = $geoIP;
    }

    public function getLocation($ipAddress)
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP) === false) {
            throw new \InvalidArgumentException("Invalid IP address: $ipAddress");
        }

        return $this->geoIP->getLocation($ipAddress);
    }
}