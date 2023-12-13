<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceUnitToAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_unit_areas', function (Blueprint $table) {
            $table->primary(['service_unit_id', 'area_id']);
            $table->foreignUuid('service_unit_id');
            $table->foreignUuid('area_id');
            $table->foreign('service_unit_id')->references('id')->on('service_units');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_unit_areas');
    }
}
