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
            $table->integer('type_id')->unsigned();
            $table->string('code');
            $table->text('name');
            $table->text('image');
            $table->text('description');
            $table->integer('price');
            $table->integer('buyPrice');
            $table->integer('installmentPrice')->nullable();
            $table->integer('cashValue')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('messageStatus')->default(0);
            $table->string('weight');
            $table->string('size');
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
