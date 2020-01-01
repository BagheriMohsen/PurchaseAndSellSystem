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
            // $table->bigInteger('order_product_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();
            $table->integer('amount');
            $table->integer('sharedSpecialAmount')->nullable();
            
            $table->string('code',100)->nullable();
            $table->char('trackingCode',100)->nullable();
            

            $table->timestamps();

            $table->foreign('user_inventory_id')->references('id')->on('users_inventory')
            ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('order_product_id')->references('id')->on('order_product')
            // ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('seller_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('agent_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('order_status_id')->references('id')->on('order_statuses')
            ->onUpdate('cascade')->onDelete('cascade');

          
        });

        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('user_id')->unsigned();
            $table->string('cartNumber',256);
            $table->string('shabaNumber',512)->nullable();
            $table->boolean('default')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

        });
        Schema::create('payment_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('payment_circulations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bank_account_id')->unsigned()->nullable();
            $table->string('receiptImage')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->integer('bill');
            $table->Date('billDate');
            $table->Date('confirmDate')->nullable();
            $table->Date('OnconfirmDate')->nullable();
            $table->string('trackingCode',256);
            $table->string('paymentMethod')->nullable();
            $table->text('billDesc')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('status_id')->references('id')->on('payment_status')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')
            ->onUpdate('cascade')->onDelete('set null');
        });

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }
    public function down()
    {
        Schema::dropIfExists('users_inventory');
        Schema::dropIfExists('money_circulations');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('payment_circulations');
    }
}
