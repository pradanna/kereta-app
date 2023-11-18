<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWagonSubTypeSpecTech extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_wagons', function (Blueprint $table) {
            $table->foreignUuid('wagon_sub_type_id')->nullable()->after('id')->unique();
            $table->foreign('wagon_sub_type_id')->references('id')->on('wagon_sub_types');
            $table->dropForeign('technical_spec_wagons_facility_wagon_id_foreign');
            $table->dropColumn('facility_wagon_id');
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
            $table->foreignUuid('facility_wagon_id')->after('id')->unique();
            $table->foreign('facility_wagon_id')->references('id')->on('facility_wagons');
            $table->dropForeign('technical_spec_wagons_wagon_sub_type_id_foreign');
            $table->dropColumn('wagon_sub_type_id');
        });
    }
}
