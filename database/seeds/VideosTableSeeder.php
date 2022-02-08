<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('videos')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 1,
                'asset_id' => rand(3, 31),
                'title' => 'The first video on Phase!',
                'description' => 'This is the first video on our website!!',
                'published' => false,
            ],
        ]);
    }
}
