<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VideoYouTubePaykeepersAndStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youtube_playlists', function (Blueprint $table) {
            $table->unsignedBigInteger('paykeeper_id')->nullable()->after('title');
            $table->enum('status', ['not_shown', 'shown'])->default('not_shown')->after('title');

            $table->foreign('paykeeper_id')->references('id')->on('paykeepers');
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
            $table->dropForeign(['paykeeper_id']);

            $table->dropColumn(['paykeeper_id']);
        });
    }
}
