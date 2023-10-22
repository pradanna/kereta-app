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
            $table->string('name');
            $table->string('stakes');
            $table->double('width')->default(0);
            $table->string('road_construction')->default('');
            $table->string('road_name')->default('');
            $table->bigInteger('city_id')->unsigned();
            $table->boolean('is_verified_by_operator')->default(false);
            $table->boolean('is_verified_by_unit_track_and_bridge')->default(false);
            $table->boolean('is_verified_by_institution')->default(false);
            $table->boolean('is_verified_by_independent')->default(false);
            $table->boolean('is_verified_by_unguarded')->default(false);
            $table->boolean('is_illegal')->default(false);
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_not_found')->default(false);
            $table->boolean('is_underpass')->default(false);
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
