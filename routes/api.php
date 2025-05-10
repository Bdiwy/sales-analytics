<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WeatherController;

Route::prefix("orders")->middleware('api')->controller(OrderController::class)->group(function () {
    Route::POST('/','create');
    Route::GET('/', 'getAllOrders');
    Route::PUT('/{id}', 'updateOrder');
    Route::GET('/{id}', 'getOrderById');
    Route::DELETE('/{id}', 'deleteOrder');
    Route::POST('/total-sales', 'getTotalSales');
    Route::POST('/most-sold', 'getMostSoldProduct');
});

Route::GET('/weather-forecast', [WeatherController::class, 'showForecast']);

