<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateMailcoachTables extends Migration
{
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('conversions_disk')->nullable();
            $table->uuid('uuid')->nullable();
        });

        Schema::table('mailcoach_email_lists', function (Blueprint $table) {
            $table->string('campaign_mailer')->nullable();
            $table->string('transactional_mailer')->nullable();
            $table->integer('welcome_mail_delay_in_minutes')->default(0);
        });

        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->longText('structured_html')->nullable();
        });

        Schema::table('mailcoach_templates', function (Blueprint $table) {
            $table->longText('structured_html')->nullable();
        });
    }

    public function down()
    {
        //
    }
}
