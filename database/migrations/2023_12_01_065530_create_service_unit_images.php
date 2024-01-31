<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceUnitImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_unit_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('service_unit_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('service_unit_id')->references('id')->on('service_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_unit_images');
    }
}
