<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaCrossingBridge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crossing_bridges', function (Blueprint $table) {
            $table->foreignUuid('area_id')->after('id');
            $table->foreignUuid('track_id')->after('area_id');
            $table->foreignUuid('created_by')->after('description')->nullable();
            $table->foreignUuid('updated_by')->after('created_by')->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('track_id')->references('id')->on('tracks');
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
        Schema::table('crossing_bridges', function (Blueprint $table) {
            $table->dropForeign('crossing_bridges_area_id_foreign');
            $table->dropForeign('crossing_bridges_track_id_foreign');
            $table->dropForeign('crossing_bridges_created_by_foreign');
            $table->dropForeign('crossing_bridges_updated_by_foreign');
            $table->dropColumn('area_id');
            $table->dropColumn('track_id');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
