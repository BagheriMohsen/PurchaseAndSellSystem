<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('agent_id')->unsigned();
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('family');
            $table->boolean('sex');
            $table->string('mobile');
            $table->boolean('status');
            $table->string('address');
            $table->text('uploadCS')->nullable();
            $table->text('level')->nullable();
            $table->boolean('reciveAuto')->default(0);
            $table->text('callCenter')->nullable();
            $table->text('porsantSeller');
            $table->integer('percent')->nullable();
            $table->integer('locallyPrice')->nullable();
            $table->integer('internalPrice')->nullable();
            $table->integer('villagePrice')->nullable();
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
        Schema::dropIfExists('users');
    }
}
