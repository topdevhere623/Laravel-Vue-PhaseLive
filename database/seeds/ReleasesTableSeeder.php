<?php

use Illuminate\Database\Seeder;

class ReleasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Release::class, 500)->create()->each(function ($release) {
            $rand = rand(1, 5);
            $genres = collect(App\Genre::all())->random($rand)->pluck('id')->toArray();
            $release->genres()->attach($genres);
        });
    }
}
