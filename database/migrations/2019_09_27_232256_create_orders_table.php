<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
        | orders table
        |--------------------------------------------------------------------------
        |*/
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->bigInteger('state_id')->unsigned()->nullable();
            $table->string('mobile');
            $table->string('telephone')->nullable();
            $table->string('fullName')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->integer('sendCost')->nullable();
            $table->integer('prePrice')->nullable();
            $table->integer('checkPrice')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->string('postalCode')->nullable();
            $table->Date('HBD_Date')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();


            $table->foreign('city_id')->references('id')->on('cities')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('state_id')->references('id')->on('states')
            ->onUpdate('cascade')->onDelete('cascade');


        });
        /*
        |--------------------------------------------------------------------------
        | pivot table order and product
        |--------------------------------------------------------------------------
        |*/
        Schema::create('order_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('count');
            $table->integer('off');

            $table->foreign('order_id')->references('id')->on('orders')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
    }
}
