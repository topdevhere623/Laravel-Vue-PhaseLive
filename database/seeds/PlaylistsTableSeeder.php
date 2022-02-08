<?php

use Illuminate\Database\Seeder;

class PlaylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('playlists')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 1,
                'name' => 'Thunderbolt\'s Bangin\' Playlist',
                'description' => 'Loud and powerful tunes'
            ],
        ]);

        DB::table('playlist_track')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'playlist_id' => 1,
                'track_id' => 1,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'playlist_id' => 1,
                'track_id' => 2,
            ],
        ]);
    }
}
