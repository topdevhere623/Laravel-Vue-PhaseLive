<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path')->unique();
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('bio')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('status')->default('active');
            $table->string('social_web')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_facebook')->nullable();
            $table->unsignedInteger('notification_setting_id')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
