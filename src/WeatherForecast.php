<?php

namespace Great\Weatherforecast;
use Great\Weatherforecast\Models\Iplocation;
use Great\Weatherforecast\Models\Forecast;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class WeatherForecast {
  public static function index() {
    $initialIpAddress = '192.168.1.91';
    return view('weatherforecast::index', compact('initialIpAddress'));
  }

  public static function getLocation($ipAddress) {
    $location = Session::get('location');
    // check if session is existing
    if($location === null) {
      // check if database has location
      $db_result = Iplocation::where('ipaddress', $ipAddress)->first();
      // if database does not has location
      if ($db_result === null) {
        // call IP Location API
        list($latitude, $longitude) = self::_call_ip_location_api($ipAddress);

        // insert location information to database
        self::_insertIplocationTable($ipAddress, $latitude, $longitude);

        // assign $location with api response
        $location = [$latitude, $longitude];
      } else {
        $location = [$db_result->latitude, $db_result->longitude];
      }
      Session::put('location', $location);
    }
    return $location;
  }

  public static function getWeatherForecast(Request $request) {
    $ipAddress = $request->input('ip_address');
    $startDate = $request->input('datetime');
    $server = $request->input('server');
    
    // when user does not select date, it is defined as the current date.
    if ($startDate === null)
      $startDate = Carbon::now()->format('Y-m-d');
    
    //  get the end date that is 5 days after a given start date
    $endDate = Carbon::parse($startDate)->addDays(4)->format('Y-m-d');

    list($latitude, $longitude) = self::getLocation($ipAddress);

    // check if database has forecasting data
    $db_result = Forecast::where('ipaddress', $ipAddress)
      ->where('startDate', $startDate)
      ->where('serviceType', $server)
      ->first();

    if($db_result === null) {
      // Get `latitude` and `longitude` with $ipAddress
      switch ($server) {
        case 'dwd-icon':
          $url = 'https://api.open-meteo.com/v1/dwd-icon?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m&start_date='.$startDate.'&end_date='.$endDate;
          break;
        
        case 'noaa-gfs':
          $url = 'https://api.open-meteo.com/v1/gfs?latitude='.$latitude.'&longitude='.$longitude.'&hourly=temperature_2m&start_date='.$startDate.'&end_date='.$endDate;
          break;
          
        default:
          break;
      }
      $forecastData = self::_getWeather($url);
      self::_insertForecastTable($ipAddress, $startDate, $server, $forecastData);
    } else {
      $forecastData = [json_decode($db_result->forecastTime), json_decode($db_result->forecastTemp)];
    }
    return view('weatherforecast::index', [
      'initialIpAddress' => $ipAddress,
      'latitude' => $latitude,
      'longitude' => $longitude,
      'forecastData' => $forecastData,
      'server' => $server
    ]);
  }

  private static function _call_ip_location_api($ipAddress) {
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

  private static function _getWeather($url) {
    $response = Http::get($url);
    $decoded_data = json_decode($response->getBody());

    $forecast_time = $decoded_data->hourly->time;
    $forecast_temperature = $decoded_data->hourly->temperature_2m;
    return [$forecast_time, $forecast_temperature];
  }

  private static function _insertIplocationTable($ipAddress, $latitude, $longitude) {
    $new_iplocation = new Iplocation;
    $new_iplocation->ipaddress = $ipAddress;
    $new_iplocation->latitude = $latitude;
    $new_iplocation->longitude = $longitude;

    $new_iplocation->save();
  }
  
  private static function _insertForecastTable($ipAddress, $startDate, $server, $forecastData) {
    // insert new forecast data into database
    $new_forecast = new Forecast;
    $new_forecast->ipaddress = $ipAddress;
    $new_forecast->startDate = $startDate;
    $new_forecast->serviceType = $server;
    $new_forecast->forecastTime = json_encode($forecastData[0]);
    $new_forecast->forecastTemp = json_encode($forecastData[1]);
    $new_forecast->save();
  }
}