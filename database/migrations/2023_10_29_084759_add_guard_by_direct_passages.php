<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuardByDirectPassages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_passages', function (Blueprint $table) {
            $table->smallInteger('guarded_by')->default(0)->after('road_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_passages', function (Blueprint $table) {
            $table->dropColumn('guarded_by');
        });
    }
}
