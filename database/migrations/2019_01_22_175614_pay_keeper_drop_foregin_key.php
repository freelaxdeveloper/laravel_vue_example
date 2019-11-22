<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PayKeeperDropForeginKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paykeepers', function (Blueprint $table) {
            $table->dropForeign(['orderid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paykeepers', function (Blueprint $table) {
            $table->foreign('orderid')->references('id')->on('transactions');
        });
    }
}
