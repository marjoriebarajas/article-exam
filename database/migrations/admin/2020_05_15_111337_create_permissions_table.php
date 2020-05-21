<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('role_id')->unsigned()->index();
            $table->integer('menu_id')->unsigned()->index();
            $table->integer('can_access')->unsigned()->index();
            $table->integer('can_create')->unsigned()->index();
            $table->integer('can_update')->unsigned()->index();
            $table->integer('can_delete')->unsigned()->index();
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
        Schema::dropIfExists('permissions');
    }
}
