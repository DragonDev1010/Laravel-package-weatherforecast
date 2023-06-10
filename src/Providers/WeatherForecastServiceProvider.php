<?php

namespace Great\Weatherforecast\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherForecastServiceProvider extends ServiceProvider
{
  public function register() {}

  public function boot()
  {
      if ($this->app->runningInConsole()) {
          $this->publishResources();
      }
  }

  protected function publishResources()
  {
      // $  php artisan vendor:publish --tag=randomable-migrations
      $this->publishes([
          __DIR__ . '/../database/migrations/create_iplocation_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_iplocation_table.php'),
      ], 'iplocation-migrations');
  }

}