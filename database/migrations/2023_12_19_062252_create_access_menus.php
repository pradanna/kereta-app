<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id');
            $table->bigInteger('app_menu_id')->unique()->unsigned();
            $table->boolean('is_granted_create')->default(false);
            $table->boolean('is_granted_update')->default(false);
            $table->boolean('is_granted_delete')->default(false);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('app_menu_id')->references('id')->on('app_menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_menus');
    }
}
