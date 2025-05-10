<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\GeminiService;
use App\Services\WeatherService;

class AiController extends Controller
{
    protected $geminiService;
    protected $orderService;

    public function __construct
    (
        GeminiService $geminiService , 
        OrderService $orderService ,
        WeatherService $weatherService
    )
    {
        $this->orderService = $orderService;
        $this->geminiService = $geminiService;
        $this->weatherService = $weatherService;
    }

    public function showSuggestions(Request $request)
    {
        $orders = $this->orderService->getMostSoldProducts();

        $weather = $this->weatherService->getWeatherForecast();

        $productSuggestions = $this->geminiService->getProductSuggestions($orders, $weather);

        return response()->json([
            'orders' => $orders['data'], 
            'weather' => $weather,
            'suggestions' => $productSuggestions,
        ]);
    }
}
