<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPassageAccidents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_passage_accidents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('direct_passage_id');
            $table->dateTime('date');
            $table->string('train_name');
            $table->string('accident_type');
            $table->integer('injured')->default(0);
            $table->integer('died')->default(0);
            $table->text('damaged_description');
            $table->text('description');
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
        Schema::dropIfExists('direct_passage_accidents');
    }
}
