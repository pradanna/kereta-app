<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRailwayStations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('railway_stations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id');
            $table->bigInteger('district_id')->unsigned();
            $table->string('name');
            $table->string('nickname');
            $table->string('stakes');
            $table->double('height')->default(0);
            $table->double('latitude');
            $table->double('longitude');
            $table->string('type');
            $table->string('status');
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('railway_stations');
    }
}
