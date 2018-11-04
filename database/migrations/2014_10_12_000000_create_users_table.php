<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('phone');
            $table->string('town');
            $table->integer('county_id');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('code');
            $table->integer('national_id');
            $table->string('pin');
            $table->integer('postbox_id');
            $table->integer('postcode_id');

            $table->boolean('active')->default(1);
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
            // $table->foreign('postbox_id')->references('id')->on('post_boxes')->onDelete('cascade');
            // $table->foreign('postcode_id')->references('id')->on('post_codes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
