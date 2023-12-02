<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectPassageSignEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_passage_sign_equipment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('direct_passage_id');
            $table->boolean('locomotive_flute')->default(false);
            $table->boolean('crossing_gate')->default(false);
            $table->boolean('non_crossing_gate')->default(false);
            $table->boolean('warning')->default(false);
            $table->boolean('critical_distance_450')->default(false);
            $table->boolean('critical_distance_300')->default(false);
            $table->boolean('critical_distance_100')->default(false);
            $table->boolean('stop_sign')->default(false);
            $table->boolean('walking_ban')->default(false);
            $table->boolean('vehicle_entry_ban')->default(false);
            $table->boolean('shock_line')->default(false);
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
        Schema::dropIfExists('direct_passage_sign_equipment');
    }
}
