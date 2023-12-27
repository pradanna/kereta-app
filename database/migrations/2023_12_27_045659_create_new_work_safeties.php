<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewWorkSafeties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_work_safeties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('project_name');
            $table->string('location');
            $table->string('consultant');
            $table->string('document')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_work_safeties');
    }
}
