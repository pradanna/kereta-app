<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorRailwayStation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('railway_stations', function (Blueprint $table) {
            $table->string('station_class')->after('status');
            $table->text('description')->after('station_class');
            $table->foreignUuid('created_by')->after('description')->nullable();
            $table->foreignUuid('updated_by')->after('created_by')->nullable();
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
        Schema::table('railway_stations', function (Blueprint $table) {
            $table->dropForeign('railway_stations_created_by_foreign');
            $table->dropForeign('railway_stations_updated_by_foreign');
            $table->dropColumn('station_class');
            $table->dropColumn('description');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
