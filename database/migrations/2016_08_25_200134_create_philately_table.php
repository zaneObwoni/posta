<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhilatelyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('philately', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cost');
            $table->string('branch');
            $table->integer('stamps');
            $table->string('phone');
            $table->string('code');
            $table->string('status');
            $table->boolean('active');
            $table->integer('user_id');
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
        Schema::drop('philately');
    }
}
