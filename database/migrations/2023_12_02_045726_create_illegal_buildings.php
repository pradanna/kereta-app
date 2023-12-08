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
            $table->bigInteger('district_id')->unsigned();
            $table->string('stakes');
            $table->double('surface_area', 8, 2)->default(0);
            $table->double('building_area', 8, 2)->default(0);
            $table->double('distance_from_rail', 8, 2)->default(0);
            $table->integer('illegal_building')->default(0);
            $table->integer('demolished')->default(0);
            $table->text('description');
            $table->timestamps();
            $table->foreign('sub_track_id')->references('id')->on('sub_tracks');
            $table->foreign('district_id')->references('id')->on('districts');
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
