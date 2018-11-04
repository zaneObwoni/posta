<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickingmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickingmails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('id_number');
            $table->string('phone');
            $table->string('tracking_code');
            $table->string('stamp_code');
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
        Schema::drop('pickingmails');
    }
}
