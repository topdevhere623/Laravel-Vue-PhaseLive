<?php

use Illuminate\Database\Seeder;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            [
                'name' => 'Ambient',
                'slug' => 'ambient',
                'image_id' => 33,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Alternative',
                'slug' => 'alternative',
                'image_id' => 34,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Bass',
                'slug' => 'bass',
                'image_id' => 35,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Breakbeat',
                'slug' => 'breakbeat',
                'image_id' => 36,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Chill',
                'slug' => 'chill',
                'image_id' => 37,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Dubstep',
                'slug' => 'dubstep',
                'image_id' => 39,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Drum & Bass',
                'slug' => 'drum-bass',
                'image_id' => 38,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'EDM',
                'slug' => 'edm',
                'image_id' => 40,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Experimental',
                'slug' => 'experimental',
                'image_id' => 41,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Garage',
                'slug' => 'garage',
                'image_id' => 42,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Grime',
                'slug' => 'grime',
                'image_id' => 43,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Hardcore & Hardstyle',
                'slug' => 'hardcore-hardstyle',
                'image_id' => 44,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'House',
                'slug' => 'house',
                'image_id' => 45,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Instrumental',
                'slug' => 'instrumental',
                'image_id' => 46,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Rap & Hip-Hop',
                'slug' => 'rap-hip-hop',
                'image_id' => 47,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Reggae',
                'slug' => 'reggae',
                'image_id' => 48,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Singer & Songwritter',
                'slug' => 'singer-songwritter',
                'image_id' => 49,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Techno',
                'slug' => 'techno',
                'image_id' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Trance',
                'slug' => 'trance',
                'image_id' => 51,
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Trap',
                'slug' => 'trap',
                'image_id' => 52,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
