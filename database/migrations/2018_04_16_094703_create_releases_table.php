<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description');
            $table->string('status');
            $table->string('class')->nullable();
            $table->integer('price');
            $table->boolean('featured')->default(0);
            $table->integer('image_id')->unsigned()->nullable();
            $table->integer('uploaded_by')->unsigned()->index();
            $table->dateTime('release_date');
            $table->dateTime('frozen_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')
                ->on('assets');
            $table->foreign('uploaded_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('releases');
    }
}
