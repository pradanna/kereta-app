<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorHumanResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('human_resources', function (Blueprint $table) {
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
        Schema::table('human_resources', function (Blueprint $table) {
            $table->dropForeign('human_resources_created_by_foreign');
            $table->dropForeign('human_resources_updated_by_foreign');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
}
