<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacilityLocomotiveIdTableTechLocomotive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_locomotives', function (Blueprint $table) {
            $table->dropForeign('technical_spec_locomotives_facility_certification_id_foreign');
            $table->dropForeign('technical_spec_locomotives_locomotive_type_id_foreign');
            $table->dropColumn('facility_certification_id');
            $table->dropColumn('locomotive_type_id');
            $table->dropColumn('type');
            $table->foreignUuid('facility_locomotive_id')->after('id');
            $table->foreign('facility_locomotive_id')->references('id')->on('facility_locomotives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_spec_locomotives', function (Blueprint $table) {
            //
        });
    }
}
