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
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->bigInteger('seller_id')->unsigned()->nullable();
            $table->bigInteger('callCenter_id')->unsigned()->nullable();
            $table->bigInteger('followUpManager_id')->unsigned()->nullable();
            $table->Date('followUpManagerConfirmDate')->nullable();
            $table->bigInteger('pay_id')->unsigned()->nullable();
            $table->string('product_array')->nullable();
            $table->char('trackingCode',250);
            $table->string('mobile');
            $table->string('telephone')->nullable();
            $table->string('fullName')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->integer('shippingCost')->default(0);
            $table->integer('prePayment')->default(0);
            $table->integer('cashPrice')->default(0);
            $table->integer('chequePrice')->default(0);
            $table->text('sellerDescription')->nullable();
            $table->text('sendDescription')->nullable();
            $table->text('statusDescription')->nullable();
            $table->string('postalCode')->nullable();
            $table->Date('HBD_Date')->nullable();
            $table->Date('returnDate')->nullable();
            $table->string('instant')->default('IsNot');
            $table->text('address')->nullable();
            $table->Date('suspended_Date')->nullable();
            $table->Date('delivary_Date')->nullable();
            $table->Date('collected_Date')->nullable();
            $table->Date('cancelled_Date')->nullable();
            $table->Date('edit_Date')->nullable();
            $table->Date('send_seller_Date')->nullable();
            $table->Date('send_callcenter_Date')->nullable();
            $table->Date('returnToSeller_Date')->nullable();
            $table->Date('returnToManager_Date')->nullable();
            $table->Date('allotment_Date')->nullable();
            $table->Date('action_Date')->nullable();
            $table->Text("status_desc")->nullable();
            $table->Date("dueDate")->nullable();
            $table->string('addressConfirm')->nullable();
            $table->string('gift')->nullable();
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('seller_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('callCenter_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('followUpManager_id')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('city_id')->references('id')->on('cities')
            // ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('state_id')->references('id')->on('states')
            // ->onUpdate('cascade')->onDelete('cascade');

            

            


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
            $table->boolean('collected')->default(0);
            $table->boolean('cancelled')->default(0);
            $table->timestamps();
            
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
