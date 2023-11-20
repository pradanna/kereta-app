<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disaster_areas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('resort_id');
            $table->foreignUuid('sub_track_id');
            $table->foreignUuid('disaster_type_id');
            $table->smallInteger('location_type')->default(0)->comment('0: Jalan Rel, 1: Jembatan');
            $table->string('block');
            $table->double('latitude')->default(0);
            $table->double('longitude')->default(0);
            $table->string('lane');
            $table->text('handling');
            $table->text('description');
            $table->timestamps();
            $table->foreign('resort_id')->references('id')->on('resorts');
            $table->foreign('sub_track_id')->references('id')->on('sub_tracks');
            $table->foreign('disaster_type_id')->references('id')->on('disaster_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disaster_areas');
    }
}
