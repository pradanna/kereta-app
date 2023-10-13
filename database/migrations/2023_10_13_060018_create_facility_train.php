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
            $table->string('ownership');
            $table->string('facility_number')->unique();
            $table->date('service_start_date');
            $table->date('service_expired_date');
            $table->string('testing_number')->unique();
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
