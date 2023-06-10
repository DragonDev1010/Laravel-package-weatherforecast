<?php

namespace Great\Weatherforecast\Models;

use Illuminate\Database\Eloquent\Model;

class Iplocation extends Model{
  public function getTable()
  {
      return 'iplocation';
  }
}