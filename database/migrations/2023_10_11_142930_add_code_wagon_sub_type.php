<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeWagonSubType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wagon_sub_types', function (Blueprint $table) {
            $table->string('code')->unique()->after('wagon_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wagon_sub_types', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
