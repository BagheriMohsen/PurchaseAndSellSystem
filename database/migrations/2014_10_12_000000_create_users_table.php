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
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        /*
        |--------------------------------------------------------------------------
        | states table
        |--------------------------------------------------------------------------
        |*/
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('state_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('state_id')->references('id')->on('states')
            ->onUpdate('cascade')->onDelete('cascade');

        });
        /*
        |--------------------------------------------------------------------------
        | users table
        |--------------------------------------------------------------------------
        |*/
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('image_id')->unsigned()->nullable();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('name');
            $table->string('family');
            $table->boolean('sex');
            $table->string('mobile');
            $table->string('status')->nullable();
            $table->string('address')->nullable();
            $table->string('uploadCS')->nullable();
            $table->string('uploadCS_status')->nullable();
            $table->string('level')->nullable();
            $table->string('backToWareHouse')->nullable();
            $table->string('backToFollowManager')->nullable();
            $table->string('sendAuto')->nullable();
            $table->string('calType')->nullable();
            $table->string('calTypeCallCenter')->nullable();
            $table->string('callCenter')->nullable();
            $table->string('callCenterType')->nullable();
            $table->string('allowNumber')->nullable();
            $table->string('allowNumberBack')->nullable();
            $table->string('allowNumberDup')->nullable();
            $table->string('allowNumberEdit')->nullable();
            $table->string('allowNewOrder')->nullable();
            $table->string('messageStatus')->nullable();
            $table->string('determinPercent')->nullable();
            $table->string('porsantType')->nullable();
            $table->string('forceOrder')->nullable();
            $table->integer('porsantSeller')->nullable();
            $table->integer('percent')->nullable();
            $table->integer('locallyPrice')->nullable();
            $table->integer('internalPrice')->nullable();
            $table->integer('villagePrice')->nullable();
            $table->integer('gift')->default(0);
            $table->timestamps();

            $table->Foreign('image_id')->references('id')->on('media')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->Foreign('state_id')->references('id')->on('states')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->Foreign('city_id')->references('id')->on('cities')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->Foreign('agent_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

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
