<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->text('name');
            $table->text('image');
            $table->text('description');
            $table->integer('price');
            $table->integer('buyPrice');
            $table->text('description')->nullable();
            // $table->integer('installmentPrice')->nullable();
            // $table->integer('cashValue')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('messageStatus')->nullable();
            // $table->string('weight');
            // $table->string('size');
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
        Schema::dropIfExists('products');
    }
}
