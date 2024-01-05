<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialToolImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_tool_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('material_tool_id');
            $table->string('image');
            $table->timestamps();
            $table->foreign('material_tool_id')->references('id')->on('material_tools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_tool_images');
    }
}
