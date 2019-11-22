<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnimationMilestoneDuration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animation_milestone', function (Blueprint $table) {
            $table->integer('duration')->default(1000)->after('animation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animation_milestone', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
}
