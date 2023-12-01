<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsSpecialEquipmen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_special_equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('special_equipment_type_id');
            $table->double('empty_weight', 8, 2);
            $table->double('maximum_speed', 8, 2);
            $table->double('passenger_capacity', 8, 2);
            $table->double('long', 8, 2);
            $table->double('width', 8, 2);
            $table->double('height', 8, 2);
            $table->double('axle_load', 8, 2);
            $table->double('coupler_height', 8, 2);
            $table->double('axle_width', 8, 2);
            $table->timestamps();
            $table->foreign('special_equipment_type_id')->references('id')->on('special_equipment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_special_equipment');
    }
}
