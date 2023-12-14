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
            $table->foreignUuid('area_id');
            $table->foreignUuid('resort_id');
            $table->string('type');
            $table->double('qty')->default(0);
            $table->string('unit');
            $table->text('description');
            $table->timestamps();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('resort_id')->references('id')->on('resorts');
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
