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
        
        /*
        |--------------------------------------------------------------------------
        | cities table
        |--------------------------------------------------------------------------
        |*/
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        /*
        |--------------------------------------------------------------------------
        | states table
        |--------------------------------------------------------------------------
        |*/
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('image_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('image_id')->references('id')->on('media')
            ->onDelete('CASCADE')->onUpdate('CASCADE');
        });
        /*
        |--------------------------------------------------------------------------
        | users table
        |--------------------------------------------------------------------------
        |*/
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('agent_id')->unsigned()->nullable();
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
            $table->boolean('sendAuto')->default(0);
            $table->text('callCenter')->nullable();
            $table->text('porsantSeller');
            $table->integer('percent')->nullable();
            $table->integer('locallyPrice')->nullable();
            $table->integer('internalPrice')->nullable();
            $table->integer('villagePrice')->nullable();

            $table->Foreign('state_id')->references('id')->on('states')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->Foreign('agent_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('cities');
        Schema::dropIfExists('states');
    }
}
