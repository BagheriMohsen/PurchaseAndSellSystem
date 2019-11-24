<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInOutColumnToStoreRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_rooms', function (Blueprint $table) {
            $table->bigInteger('in_out')->unsigned()->nullable();

            $table->foreign('in_out')->references('id')->on('store_room_statuses')
            ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_rooms', function (Blueprint $table) {
            $table->dropColumn('in_out');
        });
    }
}
