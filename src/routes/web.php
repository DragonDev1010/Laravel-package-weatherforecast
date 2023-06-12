<?php

use Illuminate\Support\Facades\Route;
use Great\Weatherforecast\WeatherForecast;

Route::get('/weather-forecast', [WeatherForecast::class, 'index']);
Route::get('/weather-forecast/{ipaddress}', [WeatherForecast::class, 'getLocation']);
Route::post('get-weather-forecast', [WeatherForecast::class, 'get_weather_forecast'])->name('get-weather-forecast');