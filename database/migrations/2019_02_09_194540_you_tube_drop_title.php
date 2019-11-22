<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class YouTubeDropTitle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youtube_playlists', function (Blueprint $table) {
            $table->dropColumn(['title', 'info']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youtube_playlists', function (Blueprint $table) {
            $table->json('info')->nullabe();
            $table->string('title');
        });
    }
}
