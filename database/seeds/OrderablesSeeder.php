<?php

use Illuminate\Database\Seeder;

class OrderablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orderables')->insert([
            [
                'order_id' => 1,
                'orderable_id' => 1,
                'orderable_type' => 'release',
                'format' => 'mp3',
                'price' => 115,
            ],
            [
                'order_id' => 2,
                'orderable_id' => 2,
                'orderable_type' => 'release',
                'format' => 'mp3',
                'price' => 115,
            ],
            [
                'order_id' => 3,
                'orderable_id' => 3,
                'orderable_type' => 'track',
                'format' => 'mp3',
                'price' => 70
            ],
            [
                'order_id' => 4,
                'orderable_id' => 4,
                'orderable_type' => 'release',
                'format' => 'mp3',
                'price' => 115,
            ],
            [
                'order_id' => 5,
                'orderable_id' => 5,
                'orderable_type' => 'release',
                'format' => 'mp3',
                'price' => 115,
            ],
            [
                'order_id' => 6,
                'orderable_id' => 6,
                'orderable_type' => 'track',
                'format' => 'mp3',
                'price' => 70
            ],
            [
                'order_id' => 7,
                'orderable_id' => 7,
                'orderable_type' => 'release',
                'format' => 'mp3',
                'price' => 115,
            ],
            [
                'order_id' => 8,
                'orderable_id' => 8,
                'orderable_type' => 'release',
                'format' => 'mp3',
                'price' => 115,
            ],
            [
                'order_id' => 9,
                'orderable_id' => 9,
                'orderable_type' => 'track',
                'format' => 'mp3',
                'price' => 70
            ],
            [
                'order_id' => 10,
                'orderable_id' => 10,
                'orderable_type' => 'track',
                'format' => 'mp3',
                'price' => 730
            ],
            [
                'order_id' => 11,
                'orderable_id' => 11,
                'orderable_type' => 'track',
                'format' => 'mp3',
                'price' => 730
            ],
            [
                'order_id' => 12,
                'orderable_id' => 12,
                'orderable_type' => 'track',
                'format' => 'mp3',
                'price' => 730
            ],
        ]);
    }
}
