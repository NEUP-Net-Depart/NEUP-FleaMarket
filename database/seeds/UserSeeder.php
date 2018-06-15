<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('administrator'),
            'nickname' => '超级管理员',
            'email' => 'admin@admin',
            'stuid' => '00000000',
            'havecheckedemail' => 1,
        ]);
    }
}
