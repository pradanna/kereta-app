<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityTrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facility_trains', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('area_id');
            $table->foreignUuid('train_type_id');
            $table->foreignUuid('storehouse_id');
            $table->enum('engine_type', ['train', 'electric-train', 'diesel-train'])->default('train');
            $table->string('ownership');
            $table->string('facility_number');
            $table->string('testing_number');
            $table->date('service_start_date')->nullable();
            $table->date('service_expired_date')->nullable();
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('train_type_id')->references('id')->on('train_types');
            $table->foreign('storehouse_id')->references('id')->on('storehouses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facility_trains');
    }
}
