<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacilityWagonIdTableTechWagon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_wagons', function (Blueprint $table) {
            $table->dropForeign('technical_spec_wagons_facility_certification_id_foreign');
            $table->dropForeign('technical_spec_wagons_wagon_sub_type_id_foreign');
            $table->dropColumn('facility_certification_id');
            $table->dropColumn('wagon_sub_type_id');
            $table->foreignUuid('facility_wagon_id')->after('id');
            $table->foreign('facility_wagon_id')->references('id')->on('facility_wagons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_spec_wagons', function (Blueprint $table) {
            //
        });
    }
}
