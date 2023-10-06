<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalSpecLocomotive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_spec_locomotives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('facility_certification_id');
            $table->foreignUuid('locomotive_type_id');
            $table->enum('type', ['general motor', 'general electric']);
            $table->float('empty_weight')->default(0);
            $table->float('house_power')->default(0);
            $table->float('maximum_speed')->default(0);
            $table->float('fuel_consumption')->default(0);
            $table->float('long')->default(0);
            $table->float('width')->default(0);
            $table->float('height')->default(0);
            $table->float('coupler_height')->default(0);
            $table->float('wheel_diameter')->default(0);
            $table->timestamps();
            $table->foreign('facility_certification_id')->references('id')->on('facility_certifications');
            $table->foreign('locomotive_type_id')->references('id')->on('locomotive_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_spec_locomotives');
    }
}
