<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddElevationDirectPassage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_passages', function (Blueprint $table) {
            $table->double('elevation')->default(0)->after('technical_documentation');
            $table->string('road_class')->after('elevation')->default('');
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
            $table->dropColumn('elevation');
            $table->dropColumn('road_class');
        });
    }
}
