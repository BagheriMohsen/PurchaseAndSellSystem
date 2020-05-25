<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->string('UserID',250);
            $table->string('fullName');
            $table->string('mobile');
            $table->string('telephone')->nullable();
            $table->string('postalCode')->nullable();
            $table->Date('HBD_Date')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();

            // $table->foreign('city_id')->references('id')->on('cities')
            // ->onUpdate('cascade')->onDelete('cascade');

            // $table->foreign('state_id')->references('id')->on('states')
            // ->onUpdate('cascade')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
