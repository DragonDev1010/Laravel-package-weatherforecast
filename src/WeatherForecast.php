<?php

namespace Great\Weatherforecast;
use Illuminate\Support\Facades\Http;
use Great\Weatherforecast\Models\Iplocation;
use Illuminate\Http\Request;

class WeatherForecast {
  public static function index() {
    $initialIpAddress = '192.168.1.91';
    return view('weatherforecast::index', compact('initialIpAddress'));
  }
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

  public function getWeatherForecast(Request $request) {
    $ipAddress = $request->input('ip_address');
    $startDate = $request->input('datetime');
    $server = $request->input('server');
    // Request : {$ipaddress, $startDate, $forecastService}
    // Get `latitude` and `longitude` with $ipAddress
    list($latitude, $longitude) = $this->getLocation($ipAddress);

    // when user does not select date, it is defined as the current date.
    if ($startDate === null)
      $startDate = Carbon::now()->format('Y-m-d');
    
    //  get the end date that is 5 days after a given start date
    $endDate = Carbon::parse($startDate)->addDays(4)->format('Y-m-d');

    switch ($server) {
      case 'dwd-icon':
        // Get forecast api url with $latitude, $longitude, $startDate, $endDate
        $url = 'https://api.open-meteo.com/v1/dwd-icon?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m&start_date='.$startDate.'&end_date='.$endDate;
        break;
        
      default:
        $url = 'https://api.open-meteo.com/v1/gfs?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m&start_date='.$startDate.'&end_date='.$endDate;
        break;
    }
    return $this->_getWeather($url);
  }

  private function _getWeather($url) {
    $response = Http::get($url);
    $decoded_data = json_decode($response->getBody());

    $forecast_time = $decoded_data->hourly->time;
    $forecast_temperature = $decoded_data->hourly->temperature_2m;
    return [$forecast_time, $forecast_temperature];
  }
}