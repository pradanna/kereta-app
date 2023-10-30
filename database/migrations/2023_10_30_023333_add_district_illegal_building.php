<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDistrictIllegalBuilding extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('illegal_buildings', function (Blueprint $table) {
            $table->bigInteger('district_id')->unsigned()->nullable()->after('sub_track_id');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('illegal_buildings', function (Blueprint $table) {
            $table->dropForeign('illegal_buildings_district_id_foreign');
            $table->dropColumn('district_id');
        });
    }
}
