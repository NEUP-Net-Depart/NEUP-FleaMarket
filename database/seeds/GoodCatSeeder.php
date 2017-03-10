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
            'cat_name' => '书籍',
            'cat_index' => '0'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '日用品',
            'cat_index' => '1'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '其他',
            'cat_index' => '3'
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '滑稽',
            'cat_index' => '2'
        ]);
    }
}
