<?php

namespace App\Contracts;

interface GeoIPServiceInterface
{
    public function getLocation($ipAddress);
}