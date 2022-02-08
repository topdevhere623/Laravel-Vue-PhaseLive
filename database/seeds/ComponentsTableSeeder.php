<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();

        DB::table('components')->insert([
            ['name' => 'PageHome', 'created_at' => $now, 'updated_at' => $now], // 1

            ['name' => 'PageNews', 'created_at' => $now, 'updated_at' => $now], // 2
            ['name' => 'PageNewsArticle', 'created_at' => $now, 'updated_at' => $now], // 3

            ['name' => 'PageAccountMyMusic', 'created_at' => $now, 'updated_at' => $now], // 4

            ['name' => 'PageUserMessages', 'created_at' => $now, 'updated_at' => $now], // 5
            ['name' => 'PageUserMessageThread', 'created_at' => $now, 'updated_at' => $now], // 6
            ['name' => 'PageUserProfileWrapper', 'created_at' => $now, 'updated_at' => $now], // 7
            ['name' => 'PageUserProfileEvents', 'created_at' => $now, 'updated_at' => $now], // 8
            ['name' => 'PageUserProfileAll', 'created_at' => $now, 'updated_at' => $now], // 9

            ['name' => 'PageAccount', 'created_at' => $now, 'updated_at' => $now], // 10
            ['name' => 'PageAccountMyReleases', 'created_at' => $now, 'updated_at' => $now], // 11
            ['name' => 'PageAccountSalesFeedback', 'created_at' => $now, 'updated_at' => $now], // 12
            ['name' => 'PageAccountSalesFeedbackTrack', 'created_at' => $now, 'updated_at' => $now], // 13
            ['name' => 'PageAccountDefault', 'created_at' => $now, 'updated_at' => $now], // 14

            ['name' => 'PageCharts', 'created_at' => $now, 'updated_at' => $now], // 15

            ['name' => 'PageRelease', 'created_at' => $now, 'updated_at' => $now], // 16
            ['name' => 'PageTrack', 'created_at' => $now, 'updated_at' => $now], // 17

            ['name' => 'PageAccountHelpSupport', 'created_at' => $now, 'updated_at' => $now], // 18

            ['name' => 'Page', 'created_at' => $now, 'updated_at' => $now], // 19

            ['name' => 'PageGenres', 'created_at' => $now, 'updated_at' => $now], // 20
            ['name' => 'PageGenresSingle', 'created_at' => $now, 'updated_at' => $now], // 21
            ['name' => 'PageNewMusic', 'created_at' => $now, 'updated_at' => $now], // 22
            ['name' => 'PageUserProfileMerch', 'created_at' => $now, 'updated_at' => $now], // 23

            ['name' => 'PageSamples', 'created_at' => $now, 'updated_at' => $now], // 24
            ['name' => 'PageSamplePacks', 'created_at' => $now, 'updated_at' => $now], // 25
            ['name' => 'PageSamplesPackSingle', 'created_at' => $now, 'updated_at' => $now], // 26
            ['name' => 'PagePost', 'created_at' => $now, 'updated_at' => $now], // 27
            ['name' => 'PageDiscover', 'created_at' => $now, 'updated_at' => $now], // 28

            ['name' => 'PageEvent', 'created_at' => $now, 'updated_at' => $now], // 29
            ['name' => 'PageVideo', 'created_at' => $now, 'updated_at' => $now], // 30
            ['name' => 'PagePlaylist', 'created_at' => $now, 'updated_at' => $now], // 31
            ['name' => 'PageMerch', 'created_at' => $now, 'updated_at' => $now], // 32

            ['name' => 'PageUserFollowed', 'created_at' => $now, 'updated_at' => $now], // 33
            ['name' => 'PageUserFavourites', 'created_at' => $now, 'updated_at' => $now], // 34
            ['name' => 'PageUserRecentlyPlayed', 'created_at' => $now, 'updated_at' => $now], // 35

            ['name' => 'PageUserProfileMusic', 'created_at' => $now, 'updated_at' => $now], // 36
            ['name' => 'PageUserProfileVideos', 'created_at' => $now, 'updated_at' => $now], // 37
            ['name' => 'PageUserProfilePosts', 'created_at' => $now, 'updated_at' => $now], // 38

            ['name' => 'PageAccountEdit', 'created_at' => $now, 'updated_at' => $now], // 39
            ['name' => 'PageAccountMarketplace', 'created_at' => $now, 'updated_at' => $now], // 40
            ['name' => 'PageAccountInvoices', 'created_at' => now(), 'updated_at' => $now], // 41

            ['name' => 'PageUserProfileReleases', 'created_at' => $now, 'updated_at' => $now], // 42

            ['name' => 'PageFailedPayment', 'created_at' => $now, 'updated_at' => $now] // 43
        ]);
    }
}
