<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->string('slug');
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->string('slug');
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('releases', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('tracks', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

    }
}
