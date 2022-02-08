<?php

use Illuminate\Database\Seeder;

class DefaultFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('files')->insert([
            // Default Track Preview
            [
                'created_at' => $now,
                'updated_at' => $now,
                'asset_id' => 1,
                'size' => 'preview',
                'path' => 'previews/preview.mp3',
                'mime' => 'audio/mp3',
            ],
            // Thunderbolt Avatar
            [
                'created_at' => $now,
                'updated_at' => $now,
                'asset_id' => 2,
                'size' => 'medium',
                'path' => 'avatars/1_original.jpg',
                'mime' => 'image/jpeg',
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'asset_id' => 2,
                'size' => 'thumb',
                'path' => 'avatars/1_original.jpg',
                'mime' => 'image/jpeg',
            ],
        ]);
    }
}
