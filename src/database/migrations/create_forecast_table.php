<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('ipaddress')->nullable(false);
            $table->date('startDate')->nullable(false);
            $table->enum('serviceType', ['dwd-icon', 'noaa-gfs'])->default('dwd-icon')->nullable(false);
            $table->json('forecastTime')->nullable();
            $table->json('forecastTemp')->nullable();
            $table->timestamps();
        });
    }

    public function getTableName()
    {
        return 'forecast';
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTableName());
    }
}

