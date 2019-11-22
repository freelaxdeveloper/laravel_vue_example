<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('message', 2048);
            $table->string('counter');
            $table->string('type');
            $table->enum('is_show', [0, 1])->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('show_stream');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');

        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('show_stream', [0, 1])->default(0)->after('message');
        });
    }
}
