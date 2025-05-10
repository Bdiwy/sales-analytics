<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WeatherController;

Route::prefix("orders")->middleware('api')->controller(OrderController::class)->group(function () {
    Route::post('/','create');
    Route::get('/', 'getAllOrders');
    Route::get('/{id}', 'getOrderById');
    Route::put('/{id}', 'updateOrder');
    Route::delete('/{id}', 'deleteOrder');
    Route::get('/total-sales', 'getTotalSales');
    Route::get('/condition', 'getOrdersByCondition');
});

Route::get('/weather-forecast', [WeatherController::class, 'showForecast']);

