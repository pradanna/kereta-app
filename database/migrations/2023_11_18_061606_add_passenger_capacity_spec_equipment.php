<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPassengerCapacitySpecEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_special_equipment', function (Blueprint $table) {
            $table->float('passenger_capacity')->default(0)->after('maximum_speed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_spec_special_equipment', function (Blueprint $table) {
            $table->dropColumn('passenger_capacity');
        });
    }
}
