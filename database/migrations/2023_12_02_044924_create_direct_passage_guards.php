<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPassageGuards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_passage_guards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('direct_passage_id');
            $table->foreignUuid('human_resource_id');
            $table->timestamps();
            $table->foreign('direct_passage_id')->references('id')->on('direct_passages');
            $table->foreign('human_resource_id')->references('id')->on('direct_passage_human_resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direct_passage_guards');
    }
}
