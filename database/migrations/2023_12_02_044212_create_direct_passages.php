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
            $table->string('road_construction');
            $table->string('road_name');
            $table->smallInteger('guarded_by')->default(0);
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_not_found')->default(false);
            $table->boolean('arrangement_proposal')->default(false);
            $table->double('accident_history', 8, 2)->default(0);
            $table->double('latitude');
            $table->double('longitude');
            $table->text('description');
            $table->string('technical_documentation');
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
