<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_tracks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('track_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
            $table->foreign('track_id')->references('id')->on('tracks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_tracks');
    }
}
