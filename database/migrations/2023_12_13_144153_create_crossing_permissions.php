<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrossingPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crossing_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sub_track_id');
            $table->string('stakes');
            $table->string('decree_number');
            $table->date('decree_date');
            $table->string('intersection');
            $table->string('building_type');
            $table->string('agency');
            $table->date('expired_date');
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
        Schema::dropIfExists('crossing_permissions');
    }
}
