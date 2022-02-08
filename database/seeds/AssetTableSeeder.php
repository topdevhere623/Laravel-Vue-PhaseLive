<?php

use Illuminate\Database\Seeder;

class AssetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('assets')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'alt' => 'Default Track Preview',
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'alt' => 'User Avatar',
            ],
        ]);
    }
}
