<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSafeties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_safeties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('work_unit');
            $table->string('supervision_consultant');
            $table->string('contractor');
            $table->string('work_package');
            $table->double('period')->default(0);
            $table->string('performance');
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
        Schema::dropIfExists('work_safeties');
    }
}
