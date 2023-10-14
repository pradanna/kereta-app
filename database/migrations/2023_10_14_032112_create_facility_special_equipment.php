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
            $table->foreignUuid('special_equipment_type_id');
            $table->foreignUuid('area_id');
            $table->foreignUuid('storehouse_id')->nullable();
            $table->string('ownership');
            $table->string('new_facility_number')->unique();
            $table->string('old_facility_number')->unique();
            $table->date('service_expired_date');
            $table->string('testing_number')->unique()->nullable();
            $table->timestamps();
            $table->foreign('special_equipment_type_id')->references('id')->on('special_equipment_types');
            $table->foreign('area_id')->references('id')->on('areas');
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
