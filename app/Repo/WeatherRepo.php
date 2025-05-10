<?php

namespace App\Repo;

use Illuminate\Support\Facades\Http;

class WeatherRepo
{
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->apiUrl = 'http://api.openweathermap.org/data/2.5/forecast';
        $this->apiKey = env('WEATHER_API_KEY');
    }
    public function getForecastByCityId($cityId = 360630)
    {
    try {
        $response = Http::get($this->apiUrl, [
            'id' => $cityId,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'en'
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    } catch (\Throwable $th) {
        throw $th;
        }
    }
}
