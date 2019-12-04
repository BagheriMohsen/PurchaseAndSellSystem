<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMoneyCirculations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->integer('balance');
            $table->boolean('debtor')->default(0);
            $table->boolean('Creditor')->default(0);
            $table->timestamps();

            $table->foreign('seller_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('agent_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('money_circulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_inventory_id')->unsigned();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->bigInteger('order_status_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned();
            $table->integer('amount');
            $table->integer('sharedSpecialAmount')->nullable();
            $table->string('paymentStatus',10)->default('unpaid');
            $table->boolean('adminConfirm')->default(0);
            $table->string('code',100)->nullable();
            $table->char('trackingCode',100)->nullable();
            $table->Date('payDate')->nullable();

            $table->timestamps();

            $table->foreign('user_inventory_id')->references('id')->on('users_inventory')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('seller_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('agent_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('order_status_id')->references('id')->on('order_statuses')
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
        Schema::dropIfExists('users_inventory');
        Schema::dropIfExists('money_circulations');
    }
}
