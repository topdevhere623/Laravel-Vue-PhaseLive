<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('description');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade');
        });
        Schema::create('playlist_track', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('playlist_id')->unsigned();
            $table->integer('track_id')->unsigned();

            $table->foreign('playlist_id')
                ->references('id')
                ->on('playlists');
            $table->foreign('track_id')
                ->references('id')
                ->on('tracks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlist_track');
        Schema::dropIfExists('playlists');
    }
}
