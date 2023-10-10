<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeTypeLocomotiveTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locomotive_types', function (Blueprint $table) {
            $table->string('code')->unique()->after('id');
            $table->enum('type', ['general-electric', 'general-motor'])->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locomotive_types', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('type');
        });
    }
}
