<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSpecialTariffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_tariffs', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->bigInteger('product_id')->unsigned();
          $table->bigInteger('user_id')->unsigned();
          $table->text('internalPrice');
          $table->text('locallyPrice');
          $table->text('villagePrice');
          $table->timestamps();

          $table->foreign('product_id')->references('id')->on('products')
          ->onUpdate('cascade')->onDelete('cascade');
          
          $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('specialtariffs');
    }
}
