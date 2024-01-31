<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterAreaImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disaster_area_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('disaster_area_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('disaster_area_id')->references('id')->on('disaster_areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disaster_area_images');
    }
}
