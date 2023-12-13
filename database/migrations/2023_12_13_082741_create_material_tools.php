<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_tools', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('resort_id');
            $table->foreignUuid('area_id');
            $table->timestamps();
            $table->foreign('resort_id')->references('id')->on('resorts');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_tools');
    }
}
