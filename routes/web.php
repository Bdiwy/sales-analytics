<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});


Route::get('test', function () {
    
     $response = Http::get("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent", [
            'key' => "AIzaSyA-fbTlswLfbxAUFqTwOnk6CYyM1reBhKI",
            'units' => 'metric',
            'lang' => 'en'
        ]);
return $response->json();
});