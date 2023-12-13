<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainBridges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_bridges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sub_track_id');
            $table->string('stakes');
            $table->string('corridor');
            $table->string('bridge_type');
            $table->string('building_type');
            $table->string('span');
            $table->date('installed_date')->nullable();
            $table->date('replaced_date')->nullable();
            $table->date('strengthened_date')->nullable();
            $table->double('volume')->default(0);
            $table->double('bolt')->default(0);
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
        Schema::dropIfExists('train_bridges');
    }
}
