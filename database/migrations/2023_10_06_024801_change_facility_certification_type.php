<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFacilityCertificationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_certifications', function (Blueprint $table) {
//            $table->dropColumn('type');
            $table->bigInteger('facility_type_id')->unsigned()->after('storehouse_id');
            $table->foreign('facility_type_id')->references('id')->on('facility_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facility_certifications', function (Blueprint $table) {
            $table->dropForeign('facility_certifications_facility_type_id_foreign');
            $table->dropColumn('facility_type_id');
//            $table->enum('type', ['locomotive', 'train', 'wagon', 'special_equipment'])->nullable()->after('storehouse_id');
        });
    }
}
