<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function showForecast(Request $request)
    {
        $cityId = $request->get('city_id', 360630);
        $forecast = $this->weatherService->getWeatherForecast($cityId);

        if (!$forecast) {
            return response()->json(['message' => 'Failed to fetch weather data.'], 500);
        }

        return response()->json($forecast);
    }
}
