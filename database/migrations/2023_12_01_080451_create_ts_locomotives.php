<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsLocomotives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_locomotives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('locomotive_type_id');
            $table->double('empty_weight', 8, 2);
            $table->double('house_power', 8, 2);
            $table->double('maximum_speed', 8, 2);
            $table->double('fuel_consumption', 8, 2);
            $table->double('long', 8, 2);
            $table->double('width', 8, 2);
            $table->double('height', 8, 2);
            $table->double('coupler_height', 8, 2);
            $table->double('wheel_diameter', 8, 2);
            $table->timestamps();
            $table->foreign('locomotive_type_id')->references('id')->on('locomotive_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_locomotives');
    }
}
