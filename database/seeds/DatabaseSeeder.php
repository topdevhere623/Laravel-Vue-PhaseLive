<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AssetTableSeeder::class);
        $this->call(DefaultFilesTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ComponentsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserNotificationSettingsTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(GenreTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(FaqCategoriesTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(ReleasesTableSeeder::class);
        $this->call(TrackTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        // $this->call(ThreadTableSeeder::class);
        // $this->call(MessageTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderablesSeeder::class);
        $this->call(DownloadsTableSeeder::class);
        $this->call(PlaylistsTableSeeder::class);
//        $this->call(SubscriptionPlansTableSeeder::class);
//        $this->call(SubscriptionsTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(VideosTableSeeder::class);
        $this->call(SharesTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
    }
}
