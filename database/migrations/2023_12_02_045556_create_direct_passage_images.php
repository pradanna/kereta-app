<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPassageImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_passage_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('direct_passage_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('direct_passage_id')->references('id')->on('direct_passages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direct_passage_images');
    }
}
