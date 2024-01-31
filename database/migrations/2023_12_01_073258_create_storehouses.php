<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorehouses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storehouses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('storehouse_type_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->foreignUuid('area_id');
            $table->string('name');
            $table->double('latitude');
            $table->double('longitude');
            $table->timestamps();
            $table->foreign('storehouse_type_id')->references('id')->on('storehouse_types');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storehouses');
    }
}
