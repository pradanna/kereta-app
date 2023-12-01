<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitySpecialEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_special_equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id');
            $table->foreignUuid('special_equipment_type_id');
            $table->foreignUuid('storehouse_id');
            $table->string('ownership');
            $table->string('old_facility_number');
            $table->string('new_facility_number');
            $table->string('testing_number');
            $table->date('service_expired_date')->nullable();
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('special_equipment_type_id')->references('id')->on('special_equipment_types');
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
        Schema::dropIfExists('facility_special_equipment');
    }
}
