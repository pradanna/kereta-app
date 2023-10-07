<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalSpecTrains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_spec_trains', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('facility_certification_id');
            $table->foreignUuid('train_type_id');
            $table->float('empty_weight')->default(0);
            $table->float('maximum_speed')->default(0);
            $table->float('passenger_capacity')->default(0);
            $table->string('air_conditioner')->default('-');
            $table->float('long')->default(0);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->float('coupler_height')->default(0);
            $table->float('axle_load')->default(0);
            $table->float('spoor_width')->default(0);
            $table->timestamps();
            $table->foreign('facility_certification_id')->references('id')->on('facility_certifications');
            $table->foreign('train_type_id')->references('id')->on('train_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_spec_trains');
    }
}
