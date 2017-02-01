<?php

use Illuminate\Database\Seeder;

class GoodCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('good_cat')->insert([
            'cat_name' => '书籍'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '日用品'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '其他'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '滑稽'
        ]);
    }
}
