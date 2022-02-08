<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('purchaser_id')->unsigned();
            $table->integer('sub_total')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('total')->default(0);
            $table->string('status')->default('pending');
            $table->string('gateway')->nullable();
            $table->string('gateway_charge')->nullable();

            $table->foreign('purchaser_id')
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
        Schema::dropIfExists('orders');
    }
}
