<?php

namespace Great\Weatherforecast;
use Great\Weatherforecast\Models\Iplocation;

class WeatherForecast {
  public static function getLocation() {
    return 'get location';
  }

  public static function insertIplocationTable() {
    $new_iplocation = new Iplocation;
    $new_iplocation->ipaddress = '192.168.1.1';
    $new_iplocation->latitude = 123.5;
    $new_iplocation->longitude = 234.5;

    $new_iplocation->save();
    return true;
  }
}