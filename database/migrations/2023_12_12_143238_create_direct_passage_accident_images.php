<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPassageAccidentImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_passage_accident_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('accident_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('accident_id')->references('id')->on('direct_passage_accidents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direct_passage_accident_images');
    }
}
