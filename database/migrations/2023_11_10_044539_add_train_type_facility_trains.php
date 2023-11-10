<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainTypeFacilityTrains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_trains', function (Blueprint $table) {
            $table->enum('engine_type', ['train', 'electric-train', 'diesel-train'])->default('train')->after('storehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_trains', function (Blueprint $table) {
            $table->dropColumn('engine_type');
        });
    }
}
