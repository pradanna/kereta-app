<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityCertifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_certifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id');
            $table->enum('type', ['locomotive', 'train', 'wagon', 'special_equipment']);
            $table->string('ownership');
            $table->string('facility_number')->unique();
            $table->date('service_start_date');
            $table->date('service_expired_date');
            $table->string('testing_number')->unique();
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_certifications');
    }
}
