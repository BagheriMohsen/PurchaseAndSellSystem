<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreRoomsTable extends Migration
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
        | WareHouser Migration
        |--------------------------------------------------------------------------
        |*/
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('telephone')->nullable();
            $table->string('postalCard')->nullable();
            $table->text('address');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('state_id')->references('id')->on('states')
            ->onDelete('cascade')->onUpdate('set null');

            $table->foreign('city_id')->references('id')->on('cities')
            ->onDelete('cascade')->onUpdate('set null');
        });
        /*
        |--------------------------------------------------------------------------
        | Storage Migration
        |--------------------------------------------------------------------------
        |*/
        Schema::create('storage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->integer('number');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('agent_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('product_id')->references('id')->on('products')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('warehouse_id')->references('id')->on('warehouses')
            ->onDelete('cascade')->onUpdate('cascade');
        });
        /*
        |--------------------------------------------------------------------------
        | Transport Migration
        |--------------------------------------------------------------------------
        |*/
        Schema::create('transports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        /*
        |--------------------------------------------------------------------------
        | store Rooms Migration
        |--------------------------------------------------------------------------
        |*/
        Schema::create('store_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('transport_id')->unsigned()->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('storage_id')->unsigned()->nullable();
            $table->bigInteger('warehouse_id')->unsigned()->nullable();
            $table->bigInteger('receiver_id')->unsigned()->nullable();
            $table->bigInteger('sender_id')->unsigned()->nullable();
            $table->bigInteger('number');
            $table->string('status');
            $table->integer('cost')->default(0);
            $table->text('description')->nullable();
            $table->string('customerName')->nullable();
            $table->date('in_date')->nullable();
            $table->date('out_date')->nullable();
            $table->timestamps();




            $table->foreign('product_id')->references('id')->on('products')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('storage_id')->references('id')->on('storage')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('warehouse_id')->references('id')->on('warehouses')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('sender_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('receiver_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('transport_id')->references('id')->on('transports')
            ->onDelete('cascade')->onUpdate('cascade');

        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('storage');
        Schema::dropIfExists('store_rooms');
    }
}
