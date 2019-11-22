<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBadgeMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_milestone', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('milestone_id');
            $table->unsignedInteger('badge_id');
            $table->timestamps();

            $table->foreign('badge_id')->references('id')->on('badges');
            $table->foreign('milestone_id')->references('id')->on('milestones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badge_milestone');
    }
}
