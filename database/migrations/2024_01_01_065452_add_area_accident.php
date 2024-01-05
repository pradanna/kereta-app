<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaAccident extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_passage_accidents', function (Blueprint $table) {
            $table->foreignUuid('area_id')->after('id');
            $table->foreignUuid('track_id')->after('area_id');
            $table->foreignUuid('sub_track_id')->after('track_id');
            $table->bigInteger('city_id')->unsigned()->after('sub_track_id');
            $table->string('stakes')->after('direct_passage_id');
            $table->text('chronology')->after('damaged_description');
            $table->double('latitude')->after('died');
            $table->double('longitude')->after('latitude');
            $table->foreignUuid('created_by')->after('description')->nullable();
            $table->foreignUuid('updated_by')->after('created_by')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->foreign('sub_track_id')->references('id')->on('sub_tracks');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_passage_accidents', function (Blueprint $table) {
            $table->dropForeign('direct_passage_accidents_area_id_foreign');
            $table->dropForeign('direct_passage_accidents_track_id_foreign');
            $table->dropForeign('direct_passage_accidents_sub_track_id_foreign');
            $table->dropForeign('direct_passage_accidents_city_id_foreign');
            $table->dropForeign('direct_passage_accidents_created_by_foreign');
            $table->dropForeign('direct_passage_accidents_updated_by_foreign');
            $table->dropColumn('area_id');
            $table->dropColumn('track_id');
            $table->dropColumn('sub_track_id');
            $table->dropColumn('city_id');
            $table->dropColumn('stakes');
            $table->dropColumn('chronology');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
