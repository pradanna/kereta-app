<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechSpecSpecialEquipmentImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_se_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ts_special_equipment_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('ts_special_equipment_id')->references('id')->on('technical_spec_special_equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_se_images');
    }
}
