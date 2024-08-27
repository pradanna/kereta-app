<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeDirectPassagesElevationString extends Migration
{
    /**
     * Run the migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_passages', function (Blueprint $table) {
            $table->string('elevation')->change();
        });
    }

    /**
     * Reverse the migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_passages', function (Blueprint $table) {
            $table->integer('elevation')->change();
        });
    }
}
