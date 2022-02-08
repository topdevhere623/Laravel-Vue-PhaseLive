<?php

use Illuminate\Database\Seeder;

class UserNotificationSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('notification_settings')->insert([
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 1,
                'activity_follower_on_me_email' => false,
                'activity_share_on_mine_email' => false,
                'activity_post_from_followee_email' => false,
                'activity_like_on_mine_email' => false,
                'activity_comment_on_mine_email' => false,
                'activity_message_email' => false,
                'phase_new_features_email' => false,
                'phase_surveys_feedback_email' => false,
                'phase_tips_offers_email' => false,
                'phase_newsletter_email' => false,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 2,
                'activity_follower_on_me_email' => false,
                'activity_share_on_mine_email' => false,
                'activity_post_from_followee_email' => false,
                'activity_like_on_mine_email' => false,
                'activity_comment_on_mine_email' => false,
                'activity_message_email' => false,
                'phase_new_features_email' => false,
                'phase_surveys_feedback_email' => false,
                'phase_tips_offers_email' => false,
                'phase_newsletter_email' => false,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 3,
                'activity_follower_on_me_email' => false,
                'activity_share_on_mine_email' => false,
                'activity_post_from_followee_email' => false,
                'activity_like_on_mine_email' => false,
                'activity_comment_on_mine_email' => false,
                'activity_message_email' => false,
                'phase_new_features_email' => false,
                'phase_surveys_feedback_email' => false,
                'phase_tips_offers_email' => false,
                'phase_newsletter_email' => false,
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => 4,
                'activity_follower_on_me_email' => false,
                'activity_share_on_mine_email' => false,
                'activity_post_from_followee_email' => false,
                'activity_like_on_mine_email' => false,
                'activity_comment_on_mine_email' => false,
                'activity_message_email' => false,
                'phase_new_features_email' => false,
                'phase_surveys_feedback_email' => false,
                'phase_tips_offers_email' => false,
                'phase_newsletter_email' => false,
            ],
        ]);
    }
}
