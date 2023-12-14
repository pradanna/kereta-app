<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityWagons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_wagons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id');
            $table->foreignUuid('wagon_sub_type_id')->nullable();
            $table->foreignUuid('storehouse_id');
            $table->string('ownership');
            $table->string('facility_number');
            $table->string('testing_number');
            $table->date('service_start_date')->nullable();
            $table->date('service_expired_date')->nullable();
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('wagon_sub_type_id')->references('id')->on('wagon_sub_types');
            $table->foreign('storehouse_id')->references('id')->on('storehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_wagons');
    }
}
