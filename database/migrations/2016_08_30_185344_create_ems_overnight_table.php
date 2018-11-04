<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmsOvernightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ems_overnight', function (Blueprint $table) {
            $table->increments('id');
            $table->string('distance');
            $table->string('weight');
            $table->integer('price');
            $table->integer('extra_weight');
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
        Schema::drop('ems_overnight');
    }
}