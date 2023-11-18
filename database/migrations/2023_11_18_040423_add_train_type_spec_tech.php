<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainTypeSpecTech extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technical_spec_trains', function (Blueprint $table) {
            $table->foreignUuid('train_type_id')->nullable()->after('id')->unique();
            $table->foreign('train_type_id')->references('id')->on('train_types');
            $table->dropForeign('technical_spec_trains_facility_train_id_foreign');
            $table->dropColumn('facility_train_id');
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
            $table->foreignUuid('facility_train_id')->after('id')->unique();
            $table->foreign('facility_train_id')->references('id')->on('facility_trains');
            $table->dropForeign('technical_spec_trains_train_type_id_foreign');
            $table->dropColumn('train_type_id');
        });
    }
}
