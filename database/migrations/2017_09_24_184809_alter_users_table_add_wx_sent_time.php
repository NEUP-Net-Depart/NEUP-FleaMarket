<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddWxSentTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'last_send_wx_time')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('last_send_wx_time')->nullable()->default(0);
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
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'last_send_wx_time')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['last_send_wx_time']);
            });
        }
    }
}
