<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechicalSpecSpecialEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_spec_special_equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('facility_special_equipment_id');
            $table->float('empty_weight')->default(0);
            $table->float('maximum_speed')->default(0);
            $table->string('air_conditioner')->default('-');
            $table->float('long')->default(0);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->float('coupler_height')->default(0);
            $table->float('axle_load')->default(0);
            $table->float('spoor_width')->default(0);
            $table->timestamps();
            $table->foreign('facility_special_equipment_id', 'tech_spec_special_equipment_id_foreign')->references('id')->on('facility_special_equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_spec_special_equipment');
    }
}
