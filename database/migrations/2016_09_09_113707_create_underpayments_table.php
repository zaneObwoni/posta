<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnderpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('underpayments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stamp_code');
            $table->integer('amount');
            $table->string('postal_code');
            $table->string('status');
            $table->integer('staff_id');
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
        Schema::drop('underpayments');
    }
}
