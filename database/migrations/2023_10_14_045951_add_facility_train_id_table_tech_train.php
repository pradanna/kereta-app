<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFacilityTrainIdTableTechTrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_trains', function (Blueprint $table) {
            $table->dropForeign('technical_spec_trains_facility_certification_id_foreign');
            $table->dropForeign('technical_spec_trains_train_type_id_foreign');
            $table->dropColumn('facility_certification_id');
            $table->dropColumn('train_type_id');
            $table->foreignUuid('facility_train_id')->after('id');
            $table->foreign('facility_train_id')->references('id')->on('facility_trains');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technical_spec_trains', function (Blueprint $table) {
            //
        });
    }
}
