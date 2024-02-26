<?php

use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTsLocomotiveDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('ts_locomotives', function (Blueprint $table) {
            DB::statement('ALTER TABLE ts_locomotives CHANGE empty_weight empty_weight DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE house_power house_power DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE maximum_speed maximum_speed DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE fuel_consumption fuel_consumption DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE `long` `long` DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE width width DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE height height DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE coupler_height coupler_height DOUBLE(15,4) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE ts_locomotives CHANGE wheel_diameter wheel_diameter DOUBLE(15,4) NOT NULL DEFAULT 0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ts_locomotives', function (Blueprint $table) {
            $table->double('empty_weight', 8, 2);
            $table->double('house_power', 8, 2);
            $table->double('maximum_speed', 8, 2);
            $table->double('fuel_consumption', 8, 2);
            $table->double('long', 8, 2);
            $table->double('width', 8, 2);
            $table->double('height', 8, 2);
            $table->double('coupler_height', 8, 2);
            $table->double('wheel_diameter', 8, 2);
        });
    }
}
