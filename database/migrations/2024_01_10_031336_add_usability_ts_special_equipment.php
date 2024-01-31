<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsabilityTsSpecialEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ts_special_equipment', function (Blueprint $table) {
            $table->string('usability')->after('spoor_width');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ts_special_equipment', function (Blueprint $table) {
            $table->dropColumn('usability');
        });
    }
}
