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

    public function getMostSoldOrders()
    {
        return $this->geminiRepo->getMostSoldOrders();
    }


    public function getProductSuggestions($orders, $weather)
    {
        $suggestedProducts = [];
        $firstForecast = $weather['list'][0];
        $temperature = $firstForecast['main']['temp'];
        if ($temperature < 10) {
            $suggestedProducts[] = 'Winter Jackets';
        }

        foreach ($orders as $order) {
            Log::info("$order");
            if ($order->total_quantity > 50) {
                $suggestedProducts[] = 'Best-selling Product ' . $order['product_name'];
            }
        }

        return $suggestedProducts;
    }
}
