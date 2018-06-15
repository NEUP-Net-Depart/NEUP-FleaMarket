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
            'cat_name' => '图书教辅',
            'cat_index' => '0',
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '数码产品',
            'cat_index' => '1',
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '休闲娱乐',
            'cat_index' => '2',
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '生活用品',
            'cat_index' => '3',
        ]);
        DB::table('good_cat')->insert([
            'cat_name' => '其他商品',
            'cat_index' => '4',
        ]);
    }
}
