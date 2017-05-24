<?php

use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++)
            DB::table('message')->insert([
                'title' => str_random(8),
                'sender_id' => 1,
                'receiver_id' => 1,
                'content' => str_random(256),
                'is_read' => rand(0, 1)
            ]);
    }
}
