<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalSpecLocomotiveImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_locomotive_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ts_locomotive_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('ts_locomotive_id')->references('id')->on('technical_spec_locomotives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_locomotive_images');
    }
}
