<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTsWagonDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ts_wagons', function (Blueprint $table) {
            DB::statement('ALTER TABLE ts_wagons CHANGE `loading_weight` loading_weight DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE empty_weight empty_weight DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE maximum_speed maximum_speed DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE `long` `long` DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE width width DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE height_from_rail height_from_rail DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE axle_load axle_load DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_wagons CHANGE boogie_distance boogie_distance DOUBLE(15,4) NOT NULL DEFAULT 0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ts_wagons', function (Blueprint $table) {
            //
        });
    }
}
