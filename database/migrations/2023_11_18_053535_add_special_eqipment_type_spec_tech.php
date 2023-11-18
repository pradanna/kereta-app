<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialEqipmentTypeSpecTech extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_special_equipment', function (Blueprint $table) {
            $table->foreignUuid('special_equipment_type_id')->nullable()->after('id')->unique('ts_se_type_id_unique');
            $table->foreign('special_equipment_type_id', 'ts_se_type_id')->references('id')->on('special_equipment_types');
            $table->dropForeign('tech_spec_special_equipment_id_foreign');
            $table->dropColumn('facility_special_equipment_id');
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
            $table->foreignUuid('facility_special_equipment_id')->after('id');
            $table->foreign('facility_special_equipment_id', 'tech_spec_special_equipment_id_foreign')->references('id')->on('facility_special_equipment');
            $table->dropForeign('ts_se_type_id');
            $table->dropColumn('special_equipment_type_id');
        });
    }
}
