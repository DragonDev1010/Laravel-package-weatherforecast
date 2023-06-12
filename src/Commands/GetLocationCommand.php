<?php

namespace Great\Weatherforecast\Commands;
use Illuminate\Console\Command;
use Great\Weatherforecast\WeatherForecast;

class GetLocationCommand extends Command {
  protected $signature = 'get-location {ipaddress}';
  protected $description = 'Get a location by IP Address';

  public function handle() {
    $ipAddress = $this->argument('ipaddress');
    $weatherForecast = new WeatherForecast();
    $location = $weatherForecast->getLocation($ipAddress);
    $this->info('Latitude: '.$location->latitude.' Longitude: '.$location->longitude);
  }
}