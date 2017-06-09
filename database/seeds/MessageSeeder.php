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
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++)
            DB::table('message')->insert([
                'sender_id' => 1,
                'receiver_id' => 1,
                'content' => $faker->text,
                'is_read' => rand(0, 1)
            ]);
        DB::table('message_contacts')->insert([
            'user_id' => 1,
            'contact_id' => 1,
            'last_contact_time' => $faker->unixTime
        ]);
    }
}
