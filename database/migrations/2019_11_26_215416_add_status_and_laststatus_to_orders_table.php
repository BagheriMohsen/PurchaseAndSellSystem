<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndLaststatusToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('status')->unsigned()->nullable();
            $table->bigInteger('lastStatus')->unsigned()->nullable();
            

            $table->foreign('status')->references('id')->on('order_statuses')
            ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('lastStatus')->references('id')->on('order_statuses')
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
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
