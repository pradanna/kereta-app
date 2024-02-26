<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTsTrainDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ts_trains', function (Blueprint $table) {
            DB::statement('ALTER TABLE ts_trains CHANGE empty_weight empty_weight DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE maximum_speed maximum_speed DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE passenger_capacity passenger_capacity DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE `long` `long` DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE width width DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE height height DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE coupler_height coupler_height DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE axle_load axle_load DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_trains CHANGE spoor_width spoor_width DOUBLE(15,4) NOT NULL DEFAULT 0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ts_trains', function (Blueprint $table) {
            //
        });
    }
}
