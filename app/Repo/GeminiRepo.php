<?php

namespace App\Repo;

use Illuminate\Support\Facades\Http;

class GeminiRepo
{
    protected $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyA-fbTlswLfbxAUFqTwOnk6CYyM1reBhKI';

    public function getMostSoldOrders()
    {
        try {
            $response = Http::withOptions([
                        'verify' => false,  
                    ])->get("{$this->apiUrl}/orders/most-sold", [
                'limit' => 10
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
