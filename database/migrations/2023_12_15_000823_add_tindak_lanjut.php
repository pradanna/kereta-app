<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTindakLanjut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('safety_assessments', function (Blueprint $table) {
            $table->string('job_scope');
            $table->string('follow_up');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('safety_assessments', function (Blueprint $table) {
            $table->dropColumn('job_scope');
            $table->dropColumn('follow_up');
        });
    }
}
