<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocomotiveTypeSpecTech extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_locomotives', function (Blueprint $table) {
            $table->foreignUuid('locomotive_type_id')->nullable()->after('id');
            $table->foreign('locomotive_type_id')->references('id')->on('locomotive_types');
            $table->dropForeign('technical_spec_locomotives_facility_locomotive_id_foreign');
            $table->dropColumn('facility_locomotive_id');
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
            $table->foreignUuid('facility_locomotive_id')->after('id')->unique();
            $table->foreign('facility_locomotive_id')->references('id')->on('facility_locomotives');
            $table->dropForeign('technical_spec_locomotives_locomotive_type_id_foreign');
            $table->dropColumn('locomotive_type_id');
        });
    }
}
