<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIllegalBuildingImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illegal_building_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('illegal_building_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('illegal_building_id')->references('id')->on('illegal_buildings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('illegal_building_images');
    }
}
