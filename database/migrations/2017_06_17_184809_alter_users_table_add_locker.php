<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddLocker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'last_get_new_message_time')
            && !Schema::hasColumn('users', 'last_send_email_time')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('last_get_new_message_time')->nullable()->default(0);
                $table->integer('last_send_email_time')->nullable()->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'last_get_new_message_time')
            && Schema::hasColumn('users', 'last_send_email_time')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['last_get_new_message_time', 'last_send_email_time']);
            });
        }
    }
}
