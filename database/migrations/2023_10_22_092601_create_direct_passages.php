<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPassages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_passages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sub_track_id');
            $table->bigInteger('city_id')->unsigned();
            $table->string('name');
            $table->string('stakes');
            $table->double('width')->default(0);
            $table->string('road_construction')->default('');
            $table->string('road_name')->default('');
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_not_found')->default(false);
            $table->boolean('is_underpass')->default(false);
            $table->boolean('arrangement_proposal')->default(false);
            $table->float('accident_history')->default(0);
            $table->double('latitude')->default(0);
            $table->double('longitude')->default(0);
            $table->text('description');
            $table->timestamps();
            $table->foreign('sub_track_id')->references('id')->on('sub_tracks');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direct_passages');
    }
}
