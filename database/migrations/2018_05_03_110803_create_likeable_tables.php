<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLikeableTables extends Migration
{
    public function up()
    {
        Schema::create('likes', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('likeable_id');
            $table->string('likeable_type');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['likeable_id', 'likeable_type', 'user_id'], 'likes_unique');
        });
    }

    public function down()
    {
        Schema::drop('likes');
    }
}
