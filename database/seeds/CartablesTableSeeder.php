<?php

use Illuminate\Database\Seeder;

class CartablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();

        DB::table('cartables')->insert([
            [
                'created_at'        => $now,
                'updated_at'        => $now,
                'user_id'           => 1,
                'cartable_type'     => 'release',
                'cartable_id'       => 1,
                'download_format'   => 'mp3',
            ],
            [
                'created_at'        => $now,
                'updated_at'        => $now,
                'user_id'           => 1,
                'cartable_type'     => 'track',
                'cartable_id'       => 1,
                'download_format'   => 'wav',
            ],
        ]);
    }
}
