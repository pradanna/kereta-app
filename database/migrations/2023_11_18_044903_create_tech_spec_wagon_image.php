<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechSpecWagonImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_wagon_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ts_wagon_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('ts_wagon_id')->references('id')->on('technical_spec_wagons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_wagon_images');
    }
}
