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
            $table->integer('priviledge');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('stuid');
            $table->string('SSO');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->boolean('havecheckedemail');
            $table->integer('role_id');
            $table->integer('baned');
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
