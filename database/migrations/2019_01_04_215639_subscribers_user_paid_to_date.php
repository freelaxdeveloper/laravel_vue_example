<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubscribersUserPaidToDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribers_user', function (Blueprint $table) {
            $table->dropColumn('paid');
        });
        Schema::table('subscribers_user', function (Blueprint $table) {
            $table->dateTime('paid')->nullable()->after('free');
            $table->integer('paid_counter')->default(0)->after('free');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers_user', function (Blueprint $table) {
            $table->dropColumn('paid');
        });
        Schema::table('subscribers_user', function (Blueprint $table) {
            $table->integer('paid')->nullable()->after('free');
            $table->dropColumn('paid_counter');
        });
    }
}
