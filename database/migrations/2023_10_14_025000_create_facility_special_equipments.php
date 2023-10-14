<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitySpecialEquipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_special_equipments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id');
            $table->string('ownership');
            $table->string('new_facility_number')->unique();
            $table->string('old_facility_number')->unique();
            $table->date('service_expired_date');
            $table->string('testing_number')->unique()->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('facility_special_equipments');
    }
}
