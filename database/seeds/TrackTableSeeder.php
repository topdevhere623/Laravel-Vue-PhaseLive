<?php

use App\Release;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrackTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        /**
         *
         * Give every release a track
         */

        $releases = Release::all();

        foreach($releases as $release) {

            $user = collect(App\User::all())->random(1)->first();
            $name = $faker->sentence(3);
            $slug = Str::slug($name);
            $status = ['pending', 'approved'];

            DB::table('tracks')->insert([
                'name' => $name,
                'length' => $faker->numberBetween(1, 10),
                'bpm' => $faker->numberBetween(60, 200),
                'key' => $faker->randomElement(),
                'price' => $faker->numberBetween(60, 200),
                'release_id' => $release->id,
                'uploaded_by' => $user->id,
                'preview_id' => 1,
                'asset_id' => 1,
                'streamable_id' => 1,
                'slug' => $slug,
                'status' => $faker->randomElement($status),
                'created_at' => $release->created_at,
                'updated_at' => now(),
            ]);
        }

    }
}
