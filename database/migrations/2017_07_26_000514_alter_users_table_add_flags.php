<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'sso_flag')
            && !Schema::hasColumn('users', 'wechat_flag')
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('sso_flag')->default(false);
                $table->boolean('wechat_flag')->default(false);
            });
        }
        User::whereNotNull('wechat_open_id')->update(['wechat_flag' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'sso_flag')
            && Schema::hasColumn('users', 'wechat_flag')
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['sso_flag']);
                $table->dropColumn(['wechat_flag']);
            });
        }
    }
}
