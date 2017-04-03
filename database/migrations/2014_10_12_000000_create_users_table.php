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
            $table->tinyInteger('privilege');
            $table->string('username')->nullable()->unique();
            $table->string('password');
            $table->string('stuid')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->boolean('havecheckedemail');
            $table->tinyInteger('role');
            $table->boolean('baned');
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
        Schema::drop('users');
    }
}
