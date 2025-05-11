<?php
namespace App\Services;

use App\Repo\GeminiRepo;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $geminiRepo;

    public function __construct(GeminiRepo $geminiRepo)
    {
        $this->geminiRepo = $geminiRepo;
    }

    public function getProductSuggestions($orders, $weather)
    {
        $suggestedProducts = [];
        $firstForecast = $weather['list'][0];
        $response =$this->geminiRepo->getSuggestedProduct($orders, $firstForecast);
        return $response;
    }
}
