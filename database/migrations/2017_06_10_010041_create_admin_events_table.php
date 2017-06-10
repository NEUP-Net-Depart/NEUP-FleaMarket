<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('admin_events', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('admin_id');
			$table->integer('target_user');
			$table->string('event');
			$table->integer('ticket_id')->nullable();
			$table->text('message');
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
		Schema::drop('admin_events');
    }
}
