<?php

use Illuminate\Support\Facades\Route;
use Great\Weatherforecast\WeatherForecast;

Route::get('/weather-forecast/{ipaddress}', [WeatherForecast::class, 'getLocation']);