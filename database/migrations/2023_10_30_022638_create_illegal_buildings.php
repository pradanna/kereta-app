<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIllegalBuildings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illegal_buildings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sub_track_id');
            $table->string('stakes');
            $table->float('surface_area')->default(0);
            $table->float('building_area')->default(0);
            $table->float('distance_from_rail')->default(0);
            $table->integer('illegal_building')->default(0);
            $table->integer('demolished')->default(0);
            $table->timestamps();
            $table->foreign('sub_track_id')->references('id')->on('sub_tracks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('illegal_buildings');
    }
}
