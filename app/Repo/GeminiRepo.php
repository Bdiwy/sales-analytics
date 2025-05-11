<?php
namespace App\Repo;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GeminiRepo
{
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyA-fbTlswLfbxAUFqTwOnk6CYyM1reBhKI';

    public function getSuggestedProduct($topOrders, $weatherCondition)
    {
        Log::info('Weather Condition:', [$weatherCondition]);
        Log::info('Top Orders:', [$topOrders]);
        try {
            // Ensure $topOrders is an array and convert to string
            $topOrdersString = is_array($topOrders) ? implode(', ', $topOrders) : $topOrders;
            // Ensure $weatherCondition is a string
            $weatherCondition = is_string($weatherCondition) ? $weatherCondition : 'unknown';

            $prompt = "Based on today's top selling products and the current weather condition: \"$weatherCondition\", suggest ONE best product to sell today. The list of top products is: $topOrdersString. Give only the product name with  explanation.";

            $response = Http::withOptions([
                'verify' => false,
            ])->post($this->apiUrl, [
                "contents" => [
                    [
                        "parts" => [
                            [
                                "text" => $prompt
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Throwable $th) {
            Log::error('Gemini API error: ' . $th->getMessage());
            throw $th;
        }
    }
}