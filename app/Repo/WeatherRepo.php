<?php

namespace App\Repo;

use Illuminate\Support\Facades\Http;

class WeatherRepo
{
    public function getForecastByCityId($cityId = 360630)
    {
    try {
        $response = Http::get("http://api.openweathermap.org/data/2.5/forecast", [
            'id' => "360630",
            'appid' => "97f476dee0cf24a3fd18a19988b3242c",
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
