<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimationMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animation_milestone', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('milestone_id');
            $table->unsignedInteger('animation_id');
            $table->timestamps();

            $table->foreign('animation_id')->references('id')->on('animations');
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
        Schema::dropIfExists('animation_milestone');
    }
}
