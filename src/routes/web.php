<?php

use Illuminate\Support\Facades\Route;
use Great\Weatherforecast\WeatherForecast;

Route::get('/weather-forecast', [WeatherForecast::class, 'index']);
Route::get('/weather-forecast/{ipaddress}', [WeatherForecast::class, 'getLocation'])->middleware('web');
Route::post('/get-weather-forecast', [WeatherForecast::class, 'getWeatherForecast'])->name('getWeatherForecast');