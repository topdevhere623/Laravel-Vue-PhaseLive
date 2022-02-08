<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();

        // create roles
        DB::table('pages')->insert([
            [ // 1
                'parent_id' => null,
                'name' => 'home',
                'title' => 'Home',
                'path' => '/',
                'user_id' => 1,
                'component_id' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 2
                'parent_id' => null,
                'name' => 'news',
                'title' => 'News',
                'path' => '/news/:category?',
                'user_id' => 1,
                'component_id' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 3
                'parent_id' => null,
                'name' => 'article',
                'title' => 'News Article',
                'path' => '/article/:article',
                'user_id' => 1,
                'component_id' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 4
                'parent_id' => 13,
                'name' => 'mymusic',
                'title' => 'Account - My Music',
                'path' => 'mymusic',
                'user_id' => 1,
                'component_id' => 4,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 5
                'parent_id' => null,
                'name' => 'followed',
                'title' => 'User Followed',
                'path' => '/user/followed',
                'user_id' => 1,
                'component_id' => 33,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 6
                'parent_id' => null,
                'name' => 'messages',
                'title' => 'User Messages',
                'path' => '/user/messages',
                'user_id' => 1,
                'component_id' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 7
                'parent_id' => null,
                'name' => 'favourites',
                'title' => 'User Favourites',
                'path' => '/user/favourites',
                'user_id' => 1,
                'component_id' => 34,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 8
                'parent_id' => null,
                'name' => 'played',
                'title' => 'User Recently Played',
                'path' => '/user/recently-played',
                'user_id' => 1,
                'component_id' => 35,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 9
                'parent_id' => null,
                'name' => 'message_thread',
                'title' => 'User Message Thread',
                'path' => '/user/thread/:threadid',
                'user_id' => 1,
                'component_id' => 6,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 10
                'parent_id' => null,
                'name' => '',
                'title' => 'User Profile Wrapper',
                'path' => '/user/:path',
                'user_id' => 1,
                'component_id' => 7,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 11
                'parent_id' => 10,
                'name' => 'profile_events',
                'title' => 'User Profile Events',
                'path' => 'events',
                'user_id' => 1,
                'component_id' => 8,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 12
                'parent_id' => 10,
                'name' => 'profile_all',
                'title' => 'User Profile All',
                'path' => '',
                'user_id' => 1,
                'component_id' => 9,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 13
                'parent_id' => null,
                'name' => '',
                'title' => 'Account',
                'path' => '/account',
                'user_id' => 1,
                'component_id' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 14
                'parent_id' => 13,
                'name' => 'account_releases',
                'title' => 'Account - My Releases',
                'path' => 'releases',
                'user_id' => 1,
                'component_id' => 11,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 15
                'parent_id' => 13,
                'name' => 'account_stats',
                'title' => 'Account - My Sales & Feedback',
                'path' => 'stats',
                'user_id' => 1,
                'component_id' => 12,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 16
                'parent_id' => 13,
                'name' => 'account_stats_track',
                'title' => 'Account - My Sales & Feedback for Track',
                'path' => 'stats/trackname',
                'user_id' => 1,
                'component_id' => 13,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 17
                'parent_id' => 13,
                'name' => 'account_default',
                'title' => 'Account Default',
                'path' => '',
                'user_id' => 1,
                'component_id' => 14,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 18
                'parent_id' => null,
                'name' => 'charts',
                'title' => 'Charts',
                'path' => '/charts',
                'user_id' => 1,
                'component_id' => 15,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 19
                'parent_id' => null,
                'name' => 'release',
                'title' => 'Release',
                'path' => '/release/:releaseid',
                'user_id' => 1,
                'component_id' => 16,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 20
                'parent_id' => null,
                'name' => 'track',
                'title' => 'Track',
                'path' => '/track/:trackid',
                'user_id' => 1,
                'component_id' => 17,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 21
                'parent_id' => null,
                'name' => 'help',
                'title' => 'Help & Support',
                'path' => '/help',
                'user_id' => 1,
                'component_id' => 18,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 22
                'parent_id' => null,
                'name' => 'samples',
                'title' => 'Sample Packs',
                'path' => '/samples',
                'user_id' => 1,
                'component_id' => 24,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 23
                'parent_id' => null,
                'name' => 'about',
                'title' => 'About',
                'path' => '/about',
                'user_id' => 1,
                'component_id' => 19,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 24
                'parent_id' => null,
                'name' => 'contact',
                'title' => 'Contact',
                'path' => '/contact',
                'user_id' => 1,
                'component_id' => 19,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 25
                'parent_id' => null,
                'name' => 'discover',
                'title' => 'Discover',
                'path' => '/discover',
                'user_id' => 1,
                'component_id' => 28,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 26
                'parent_id' => null,
                'name' => 'new',
                'title' => 'New Music',
                'path' => '/new',
                'user_id' => 1,
                'component_id' => 22,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 27
                'parent_id' => null,
                'name' => 'genres',
                'title' => 'Genres',
                'path' => '/genres',
                'user_id' => 1,
                'component_id' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 28
                'parent_id' => null,
                'name' => 'services',
                'title' => 'Services',
                'path' => '/services',
                'user_id' => 1,
                'component_id' => 19,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 29
                'parent_id' => null,
                'name' => 'legal',
                'title' => 'Legal',
                'path' => '/legal',
                'user_id' => 1,
                'component_id' => 19,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 30
                'parent_id' => null,
                'name' => 'privacy',
                'title' => 'Privacy',
                'path' => '/privacy',
                'user_id' => 1,
                'component_id' => 19,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 31
                'parent_id' => null,
                'name' => 'genre',
                'title' => 'Genre',
                'path' => '/genres/:genreid',
                'user_id' => 1,
                'component_id' => 21,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 32
                'parent_id' => 10,
                'name' => 'profile_merch',
                'title' => 'User Profile Merch',
                'path' => 'merch',
                'user_id' => 1,
                'component_id' => 23,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 33
                'parent_id' => 10,
                'name' => 'profile_music',
                'title' => 'User Profile Music',
                'path' => 'music',
                'user_id' => 1,
                'component_id' => 36,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 34
                'parent_id' => 10,
                'name' => 'profile_videos',
                'title' => 'User Profile Videos',
                'path' => 'videos',
                'user_id' => 1,
                'component_id' => 37,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 35
                'parent_id' => 10,
                'name' => 'profile_posts',
                'title' => 'User Profile Posts',
                'path' => 'posts',
                'user_id' => 1,
                'component_id' => 38,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 36
                'parent_id' => null,
                'name' => 'sample',
                'title' => 'Sample Pack',
                'path' => '/samples/genre/:genreid',
                'user_id' => 1,
                'component_id' => 25,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 37
                'parent_id' => null,
                'name' => 'sample_single',
                'title' => 'Sample Pack Single',
                'path' => '/samples/:releaseid',
                'user_id' => 1,
                'component_id' => 26,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 38
                'parent_id' => null,
                'name' => 'post',
                'title' => 'Post',
                'path' => '/post/:postid',
                'user_id' => 1,
                'component_id' => 27,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 39
                'parent_id' => null,
                'name' => 'event',
                'title' => 'Event',
                'path' => '/event/:eventid',
                'user_id' => 1,
                'component_id' => 29,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 40
                'parent_id' => null,
                'name' => 'video',
                'title' => 'Video',
                'path' => '/video/:videoid',
                'user_id' => 1,
                'component_id' => 30,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 41
                'parent_id' => null,
                'name' => 'playlist',
                'title' => 'Playlist',
                'path' => '/playlist/:playlistid',
                'user_id' => 1,
                'component_id' => 31,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 42
                'parent_id' => null,
                'name' => 'merch',
                'title' => 'Merch',
                'path' => '/merch/:merchid',
                'user_id' => 1,
                'component_id' => 32,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 43
                'parent_id' => 13,
                'name' => 'account_edit',
                'title' => 'Account - Profile',
                'path' => 'profile',
                'user_id' => 1,
                'component_id' => 39,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [ // 44
                'parent_id' => 13,
                'name' => 'account_marketplace',
                'title' => 'Account - Marketplace',
                'path' => 'verification',
                'user_id' => 1,
                'component_id' => 40,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [ // 45
                'parent_id' => 13,
                'name' => 'account_invoices',
                'title' => 'Account - Invoices',
                'path' => 'invoices',
                'user_id' => 1,
                'component_id' => 41,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [ // 46
                'parent_id' => 10,
                'name' => 'profile_releases',
                'title' => 'User Profile Releases',
                'path' => 'releases',
                'user_id' => 1,
                'component_id' => 42,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [ // 47
                'parent_id' => 10,
                'name' => 'profile_favourites',
                'title' => 'User Profile Favourites',
                'path' => 'favourites',
                'user_id' => 1,
                'component_id' => 34,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'parent_id' => null,
                'name' => 'failed_payments',
                'title' => 'Failed Payments',
                'path' => '/featured-dates-order/:order_id/failed',
                'user_id' => 1,
                'component_id' => 43,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
