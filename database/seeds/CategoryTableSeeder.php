<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = now();

        DB::table('categories')->insert([
			['title' => 'Lifestyle', 'path' => '/lifestyle',  'created_at' => $now, 'updated_at' => $now],
			['title' => 'Trends', 'path' => '/trends',  'created_at' => $now, 'updated_at' => $now],
			['title' => 'Underground', 'path' => '/underground',  'created_at' => $now, 'updated_at' => $now],
			['title' => 'Phase', 'path' => '/phase',  'created_at' => $now, 'updated_at' => $now],
    	]);
    }
}
