<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewWorkSafetyDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_work_safety_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('new_work_safety_id');
            $table->string('name');
            $table->string('document');
            $table->timestamps();
            $table->foreign('new_work_safety_id')->references('id')->on('new_work_safeties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_work_safety_documents');
    }
}
