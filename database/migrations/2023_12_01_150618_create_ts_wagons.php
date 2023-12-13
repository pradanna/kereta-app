<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsWagons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_wagons', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wagon_sub_type_id');
            $table->double('loading_weight', 8, 2);
            $table->double('empty_weight', 8, 2);
            $table->double('maximum_speed', 8, 2);
            $table->double('long', 8, 2);
            $table->double('width', 8, 2);
            $table->double('height_from_rail', 8, 2);
            $table->double('axle_load', 8, 2);
            $table->double('boogie_distance', 8, 2);
            $table->string('usability');
            $table->timestamps();
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
        Schema::dropIfExists('ts_wagons');
    }
}
