<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrossingBridges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crossing_bridges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sub_track_id');
            $table->string('stakes');
            $table->string('recommendation_number');
            $table->string('responsible_person');
            $table->double('long')->default(0);
            $table->double('width')->default(0);
            $table->string('road_class');
            $table->text('description');
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
        Schema::dropIfExists('crossing_bridges');
    }
}
