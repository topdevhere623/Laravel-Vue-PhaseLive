<?php

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('events')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 1,
                'image_id' => rand(3, 31),
                'name' => 'Thunderbolt Party!',
                'location' => 'The Thunderbolt Office',
                'url' => 'https://www.wearethunderbolt.com/',
                'date' => (clone $now)->addMonth(),
            ],
        ]);
    }
}
