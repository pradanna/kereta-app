<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDirectPassageGuards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_passage_guards', function (Blueprint $table) {
            $table->dropColumn('is_verified_by_operator');
            $table->dropColumn('is_verified_by_unit_track_and_bridge');
            $table->dropColumn('is_verified_by_institution');
            $table->dropColumn('is_verified_by_unguarded');
            $table->dropColumn('is_illegal');
            $table->foreignUuid('human_resource_id')->after('direct_passage_id');
            $table->foreign('human_resource_id')->references('id')->on('direct_passage_human_resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_passage_guards', function (Blueprint $table) {
            //
            $table->boolean('is_verified_by_operator')->default(false);
            $table->boolean('is_verified_by_unit_track_and_bridge')->default(false);
            $table->boolean('is_verified_by_institution')->default(false);
            $table->boolean('is_verified_by_unguarded')->default(false);
            $table->boolean('is_illegal')->default(false);
            $table->dropForeign('direct_passage_guards_human_resource_id_foreign');
            $table->dropColumn('human_resource_id');
        });
    }
}
