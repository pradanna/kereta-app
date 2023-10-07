<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStorhouseTypeIdStorehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('storehouses', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->bigInteger('storehouse_type_id')->unsigned()->after('id');
            $table->foreign('storehouse_type_id')->references('id')->on('storehouse_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('storehouses', function (Blueprint $table) {
            $table->dropForeign('storehouses_storehouse_type_id_foreign');
            $table->dropColumn('storehouse_type_id');
            $table->enum('type', ['locomotive', 'train', 'train_supervisor', 'wagon', 'wagon_office', 'electric_train', 'facility_supervisor'])->after('name')->nullable();
        });
    }
}
