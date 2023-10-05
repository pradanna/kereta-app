<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorehouse extends Migration
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
            $table->string('name');
            $table->enum('type', ['locomotive', 'train', 'train_supervisor', 'wagon', 'wagon_office', 'electric_train', 'facility_supervisor']);
            $table->foreignUuid('area_id');
            $table->bigInteger('city_id')->unsigned();
            $table->timestamps();
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
