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
            'cat_name' => '我是分类1'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '我是分类2'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '我是滑稽'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '我是分类4'
        ]);
    }
}
