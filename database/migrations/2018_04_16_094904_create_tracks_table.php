<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->integer('length')->nullable();
            $table->integer('bpm');
            $table->string('key');
            $table->unsignedInteger('asset_id')->nullable()->index();
            $table->unsignedInteger('preview_id')->nullable();
            $table->unsignedInteger('streamable_id')->nullable();
            $table->unsignedInteger('release_id')->nullable()->index();
            $table->unsignedInteger('uploaded_by')->nullable()->index();
            $table->unsignedInteger('price');
            $table->string('status')->default('pending');
            $table->dateTime('frozen_at')->nullable();
            $table->softDeletes();

            $table->foreign('asset_id')->references('id')->on('assets');
            $table->foreign('preview_id')->references('id')->on('assets');
            $table->foreign('streamable_id')->references('id')->on('assets');
            $table->foreign('release_id')->references('id')->on('releases');
            $table->foreign('uploaded_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
