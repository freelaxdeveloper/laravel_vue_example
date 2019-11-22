<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PayKeeperWhoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paykeepers', function (Blueprint $table) {
            $table->unsignedInteger('who_id')->nullable()->after('status');
            $table->unsignedInteger('user_id')->nullable()->after('status');

            $table->foreign('who_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
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
            $table->dropForeign(['who_id', 'user_id']);

            $table->dropColumn(['who_id', 'user_id']);
        });
    }
}
