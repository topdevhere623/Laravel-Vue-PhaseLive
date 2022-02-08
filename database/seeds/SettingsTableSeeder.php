<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = now();

        DB::table('settings')->insert([
			[
                'created_at' => $now,
                'updated_at' => $now,
				'public' => true,
				'key' => 'title',
                'value' => 'Phase',
			],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => true,
                'key' => 'logo_title',
                'value' => 'the home of underground music',
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => false,
                'key' => 'admin_email',
                'value' => 'admin@phase.local',
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => true,
                'key' => 'wav_fee',
                'value' => 75,
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => true,
                'key' => 'tax_rate',
                'value' => 0.2,
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => true,
                'key' => 'purchase_approval_threshold',
                'value' => 10000,
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => false,
                'key' => 'banned_words',
                'value' => 'shit,bullshit,bitch,fuck,cunt,bellend,dickhead,prick,twat,bugger,wanker',
            ],

            [
                'created_at' => $now,
                'updated_at' => $now,
                'public' => false,
                'key' => 'featured_spot_price',
                'value' => 3,
            ],
    	]);
    }
}
