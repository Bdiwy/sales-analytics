<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WeatherController;

Route::middleware('api')->controller(OrderController::class)->group(function () {
    Route::post('/orders','create');
    Route::get('/orders', 'getAllOrders');
    Route::get('/orders/{id}', 'getOrderById');
    Route::put('/orders/{id}', 'updateOrder');
    Route::delete('/orders/{id}', 'deleteOrder');
    Route::get('/orders/date-range', 'getOrdersByDateRange');
    Route::get('/orders/total-sales', 'getTotalSales');
    Route::get('/orders/condition', 'getOrdersByCondition');
});

Route::get('/weather-forecast', [WeatherController::class, 'showForecast']);

