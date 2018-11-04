<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBestwishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bestwishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sender_phone');
            $table->string('sender_name');
            $table->string('season');
            $table->string('recipient_name');
            $table->string('recipient_box');
            $table->string('recipient_code');
            $table->string('recipient_town');
            $table->string('recipient_email');
            $table->string('message');
            $table->string('letter_weight');
            $table->string('code', 10);
            $table->integer('price');
            $table->integer('user_id');
            $table->integer('status');
            $table->integer('active');
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
        Schema::drop('bestwishes');
    }
}
