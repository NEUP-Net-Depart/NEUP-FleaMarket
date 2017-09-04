<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddTelAndFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')
            && !Schema::hasColumn('users', 'tel')   // Telephone number
            && !Schema::hasColumn('users', 'tel_notify')    // Whether allow telephone message notification
            && !Schema::hasColumn('users', 'email_notify')  // Whether allow email message notification
            && !Schema::hasColumn('users', 'wechat_notify') // Whether allow wechat message notification
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('tel')->nullable();
                $table->boolean('tel_notify')->default(true);
                $table->boolean('email_notify')->default(true);
                $table->boolean('wechat_notify')->default(true);
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
        if (Schema::hasTable('users')
            && Schema::hasColumn('users', 'tel')
            && Schema::hasColumn('users', 'tel_notify')
            && Schema::hasColumn('users', 'email_notify')
            && Schema::hasColumn('users', 'wechat_notify')
        ) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn([
                    'tel',
                    'tel_notify',
                    'email_notify',
                    'wechat_notify'
                ]);
            });
        }
    }
}
