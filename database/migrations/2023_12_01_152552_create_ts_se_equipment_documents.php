<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsSeEquipmentDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_se_equipment_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ts_special_equipment_id');
            $table->string('document');
            $table->string('name');
            $table->timestamps();
            $table->foreign('ts_special_equipment_id')->references('id')->on('ts_special_equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_se_equipment_documents');
    }
}
