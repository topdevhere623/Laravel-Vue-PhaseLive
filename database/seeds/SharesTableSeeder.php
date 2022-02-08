<?php

use App\Share;
use Illuminate\Database\Seeder;

class SharesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Share::class, 200)->create();
    }
}
