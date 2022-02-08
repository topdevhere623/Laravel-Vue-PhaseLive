<?php

use Illuminate\Database\Seeder;

class SubscriptionPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        DB::table('subscription_plans')->insert([
            [
                'created_at'        => $now,
                'updated_at'        => $now,
                'name'              => 'Professional Premium',
                'description'       => 'The premium phase experience!',
                'monthly_cost'      => 500,
            ],
            [
                'created_at'        => $now,
                'updated_at'        => $now,
                'name'              => 'The Ultimate Phase Experince',
                'description'       => 'The top package for the top members!',
                'monthly_cost'      => 1000,
            ],
        ]);
    }
}
