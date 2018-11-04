<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estamps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender_phone');
            $table->string('destination_box');
            $table->string('destination_code');
            $table->string('recipient_phone');
            $table->double('letter_weight');
            $table->double('price');
            $table->integer('user_id')->unsigned();
            $table->boolean('active');
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
        Schema::drop('estamps');
    }
}
