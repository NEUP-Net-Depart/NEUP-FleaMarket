<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'privilege' => 2,
            'username' => 'admin',
            'password' => sha1('administrator'),
            'nickname' => '超级管理员',
            'email' => 'admin@admin',
            'stuid' => '00000000',
            'havecheckedemail' => 1
        ]);
        DB::table('user_info')->insert([
            'realname' => '超级管理员'
        ]);
    }
}
