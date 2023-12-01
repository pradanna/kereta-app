<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsTrainImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_train_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ts_train_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('ts_train_id')->references('id')->on('ts_trains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_train_images');
    }
}
