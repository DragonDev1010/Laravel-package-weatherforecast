<?php

namespace Great\Weatherforecast;
use Illuminate\Support\Facades\Http;
use Great\Weatherforecast\Models\Iplocation;

class WeatherForecast {
  public static function getLocation($ipAddress) {
    $apiKey = config('weatherForecast.api_key');
    $lang = "en";
    $fields = "*";
    $excludes = "";

    $url = "https://api.ipgeolocation.io/ipgeo?apiKey=" . $apiKey . "&ip=" . $ipAddress . "&lang=" . $lang . "&fields=" . $fields . "&excludes=" . $excludes;

    $response = Http::get($url);
    $decoded_data = json_decode($response->getBody());
    $latitude = $decoded_data->latitude;
    $longitude = $decoded_data->longitude;
    return [$latitude, $longitude];
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