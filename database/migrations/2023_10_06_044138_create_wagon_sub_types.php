<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWagonSubTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagon_sub_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('wagon_type_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('wagon_type_id')->references('id')->on('wagon_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagon_sub_types');
    }
}
