<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tickets', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('sender_id');
			$table->integer('trans_id');
			$table->integer('receiver_id');
			$table->tinyInteger('type');
			$table->string('message');
			$table->integer('assignee');
			$table->integer('state');
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
		Schema::drop('tickets');
    }
}
