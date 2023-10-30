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
            $table->foreignUuid('direct_passage_id')->unique();
            $table->boolean('is_verified_by_operator')->default(false);
            $table->boolean('is_verified_by_unit_track_and_bridge')->default(false);
            $table->boolean('is_verified_by_institution')->default(false);
            $table->boolean('is_verified_by_unguarded')->default(false);
            $table->boolean('is_illegal')->default(false);
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
        Schema::dropIfExists('direct_passage_guards');
    }
}
