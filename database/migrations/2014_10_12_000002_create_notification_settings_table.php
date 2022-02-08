<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

            // Activity Email
            $table->boolean('activity_follower_on_me_email');
            $table->boolean('activity_share_on_mine_email');
            $table->boolean('activity_post_from_followee_email');
            $table->boolean('activity_like_on_mine_email');
            $table->boolean('activity_comment_on_mine_email');
            $table->boolean('activity_message_email');

            // Phase Email
            $table->boolean('phase_new_features_email');
            $table->boolean('phase_surveys_feedback_email');
            $table->boolean('phase_tips_offers_email');
            $table->boolean('phase_newsletter_email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
