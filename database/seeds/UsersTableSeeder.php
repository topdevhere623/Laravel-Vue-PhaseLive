<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$now = Carbon\Carbon::now();

		DB::table('users')->insert([
			[
				'avatar_id' => null,
				'path' => 'thunderbolt_digital',
				'name' => 'Thunderbolt Digital',
				'phone' => '123456789',
				'first_name' => 'Thunderbolt',
				'last_name' => 'Digital',
				'bio' => 'We pride ourselves on creating innovative, unique, and breathtakingly beautiful bespoke websites.',
				'email' => 'michael@wearethunderbolt.com',
				'password' => Hash::make('password'),
				'social_web' => 'https://www.thunderboltdigital.com',
				'social_youtube' => 'https://www.youtube.com',
				'social_twitter' => 'https://www.twitter.com',
				'social_facebook' => 'https://www.facebook.com',
				'created_at' => $now,
				'updated_at' => $now,
                'stripe_account_id' => 'acct_1HsGRER5tmjhOmxM',
                'stripe_id' => 'cus_IsX4U7V083buoD',
			], [
				'avatar_id' => null,
				'path' => 'callum',
				'name' => 'Callum',
				'phone' => '123456789',
				'first_name' => 'Callum',
				'last_name' => 'Thomson',
				'bio' => '',
				'email' => 'callum@wearethunderbolt.com',
				'password' => Hash::make('password'),
				'social_web' => 'https://www.thunderboltdigital.com',
				'social_youtube' => 'https://www.youtube.com',
				'social_twitter' => 'https://www.twitter.com',
				'social_facebook' => 'https://www.facebook.com',
				'created_at' => $now,
				'updated_at' => $now,
                'stripe_account_id' => '',
                'stripe_id' => '',
			], [
				'avatar_id' => null,
				'path' => 'nick',
				'name' => 'Nick',
				'phone' => '123456789',
				'first_name' => 'Nick',
				'last_name' => 'Fairchild',
				'bio' => '',
				'email' => 'nick.f@wearethunderbolt.com',
				'password' => Hash::make('password'),
				'social_web' => 'https://www.thunderboltdigital.com',
				'social_youtube' => 'https://www.youtube.com',
				'social_twitter' => 'https://www.twitter.com',
				'social_facebook' => 'https://www.facebook.com',
				'created_at' => $now,
				'updated_at' => $now,
                'stripe_account_id' => '',
                'stripe_id' => '',
			],
			[
				'avatar_id' => null,
				'path' => 'sam',
				'name' => 'Sam',
				'phone' => '123456789',
				'first_name' => 'Sam',
				'last_name' => 'P',
				'bio' => '',
				'email' => 'Sam.palf@hotmail.com',
				'password' => Hash::make('Phase247365'),
				'social_web' => 'https://www.thunderboltdigital.com',
				'social_youtube' => 'https://www.youtube.com',
				'social_twitter' => 'https://www.twitter.com',
				'social_facebook' => 'https://www.facebook.com',
				'created_at' => $now,
				'updated_at' => $now,
                'stripe_account_id' => '',
                'stripe_id' => '',
			],
		]);
	}
}
