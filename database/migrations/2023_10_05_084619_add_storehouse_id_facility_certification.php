<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStorehouseIdFacilityCertification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facility_certifications', function (Blueprint $table) {
            $table->foreignUuid('storehouse_id')->after('area_id');
            $table->foreign('storehouse_id')->references('id')->on('storehouses');
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
            //
            $table->dropForeign('facility_certifications_storehouse_id_foreign');
            $table->dropColumn('storehouse_id');
        });
    }
}
