<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserAddWechatId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'wechat_open_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('wechat_open_id')->nullable()->unique();
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
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'wechat_open_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('wechat_open_id');
            });
        }
    }
}
