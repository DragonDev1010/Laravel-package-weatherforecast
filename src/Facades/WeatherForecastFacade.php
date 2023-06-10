<?php

namespace Great\Weatherforecast\Facades;

use Illuminate\Support\Facades\Facade;
use Great\Weatherforecast\WeatherForecast;

class WeatherForecastFacade extends Facade {
  public static function getFacadeAccessor()
  {
    return WeatherForecast::class;
  }
}