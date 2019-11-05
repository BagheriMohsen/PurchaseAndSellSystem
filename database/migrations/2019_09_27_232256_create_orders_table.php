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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('seller_id')->unsigned();
            $table->bigInteger('supervisor_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('state_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->boolean('sellerAllow')->default(0);
            $table->boolean('supervisior_confirm_date')->default(0);
            $table->string('agent_level');
            $table->string('customerName');
            $table->string('customerFamily');
            $table->string('postalCard');
            $table->string('address');
            $table->string('phoneNumber');
            $table->timestamps();


            $table->foreign('seller_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('supervisor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');

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
    }
}
