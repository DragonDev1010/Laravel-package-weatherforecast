<?php

namespace Great\Weatherforecast\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model{
  public function getTable()
  {
      return 'forecast';
  }
}