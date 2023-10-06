<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalSpecWagons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_spec_wagons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('facility_certification_id');
            $table->foreignUuid('wagon_sub_type_id');
            $table->float('loading_weight')->default(0);
            $table->float('empty_weight')->default(0);
            $table->float('maximum_speed')->default(0);
            $table->float('long')->default(0);
            $table->float('width')->default(0);
            $table->float('height_from_rail')->default(0);
            $table->float('axle_load')->default(0);
            $table->float('bogie_distance')->default(0);
            $table->string('usability')->default('-');
            $table->timestamps();
            $table->foreign('facility_certification_id')->references('id')->on('facility_certifications');
            $table->foreign('wagon_sub_type_id')->references('id')->on('wagon_sub_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_spec_wagons');
    }
}
