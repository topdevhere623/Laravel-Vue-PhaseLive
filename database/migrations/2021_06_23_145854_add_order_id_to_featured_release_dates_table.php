<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToFeaturedReleaseDatesTable extends Migration
{
    public function up()
    {
        Schema::table('featured_release_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable();

            $table->foreign('order_id')
                ->references('id')
                ->on('featured_orders');
        });
    }

    public function down()
    {
        Schema::table('featured_release_dates', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
}
