<?php

use Illuminate\Database\Seeder;

class DownloadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('downloads')->insert([
            [
                'created_at' => now(),
                'updated_at' => now(),
                'order_id' => 1,
                'track_id' => 1,
                'format' => 'mp3',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'order_id' => 1,
                'track_id' => 2,
                'format' => 'mp3',
            ],
            [
                'created_at' => now(),
                'updated_at' => now(),
                'order_id' => 1,
                'track_id' => 1,
                'format' => 'mp3',
            ],
        ]);
    }
}
