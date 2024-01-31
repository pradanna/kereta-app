<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('direct_passage_sign_equipment', function (Blueprint $table) {
            $table->boolean('crossing_exists')->default(false);
            $table->boolean('obstacles')->default(false);
            $table->boolean('noise_band')->default(false);
            $table->boolean('approach')->default(false);
            $table->boolean('look_around')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direct_passage_sign_equipment', function (Blueprint $table) {
            $table->dropColumn('crossing_exists');
            $table->dropColumn('obstacles');
            $table->dropColumn('noise_band');
            $table->dropColumn('approach');
            $table->dropColumn('look_around');
        });
    }
}
