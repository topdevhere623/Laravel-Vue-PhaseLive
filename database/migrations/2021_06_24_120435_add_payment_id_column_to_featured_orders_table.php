<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentIdColumnToFeaturedOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('featured_orders', function (Blueprint $table) {
            $table->string('payment_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('featured_orders', function (Blueprint $table) {
            $table->dropColumn('payment_id');
        });
    }
}
