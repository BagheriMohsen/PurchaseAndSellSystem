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
            $table->bigInteger('image_id')->unsigned();
            $table->string('code');
            $table->text('name');
            $table->integer('price');
            $table->integer('buyPrice');
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->string('messageStatus')->nullable();
            $table->timestamps();


            $table->Foreign('image_id')->references('id')->on('media')
            ->onDelete('CASCADE')->onUpdate('CASCADE');
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
