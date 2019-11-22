<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PaykeeperStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paykeepers', function (Blueprint $table) {
            $table->enum('status', ['created', 'sent', 'paid', 'expired'])
                ->default('created')
                ->after('id')
                ->comment('Статус плятежа');
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
            $table->dropColumn('paykeepers');
        });
    }
}
