<?php

namespace App\Services;

use App\Repo\WeatherRepo;

class WeatherService
{
    protected $weatherRepo;

    public function __construct(WeatherRepo $weatherRepo)
    {
        $this->weatherRepo = $weatherRepo;
    }

    public function getWeatherForecast($cityId = 360630)
    {
        return $this->weatherRepo->getForecastByCityId($cityId);
    }
}
