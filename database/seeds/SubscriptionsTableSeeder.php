<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $today = startOfToday();
        DB::table('subscriptions')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 1,
                'subscription_plan_id' => 1,
                'trial_ends_at' => $today->addWeeks(1),
                'ends_at' => $today->addWeeks(1),
                'renew' => true,
            ],
        ]);
    }
}
