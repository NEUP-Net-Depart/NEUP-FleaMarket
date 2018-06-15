<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->string('password')->nullable();
            $table->string('stuid')->nullable();
            $table->string('realname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('email')->nullable()->unique();
            $table->boolean('havecheckedemail');
            $table->tinyInteger('role');
            $table->boolean('baned');
            $table->integer('banedtime');
            $table->integer('banedstart');
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
