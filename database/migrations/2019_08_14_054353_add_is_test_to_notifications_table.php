<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Notification;

class AddIsTestToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->boolean('is_test')->default(0)->after('is_show');
        });
        Notification::whereTitle('{{user}} перевел вам {{amount}}')->update(['is_test' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Notification::whereTitle('{{user}} перевел вам {{amount}}')->update(['is_test' => false]);

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['is_test']);
        });
    }
}
