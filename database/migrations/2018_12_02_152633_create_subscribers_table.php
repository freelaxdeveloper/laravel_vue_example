<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('_id');
            $table->text('bio')->nullable();
            $table->string('type', 64);
            $table->string('display_name', 64);
            $table->string('logo');
            $table->string('name', 64);
            $table->unsignedInteger('service_id');
            $table->timestamps();

            $table->unique(['_id', 'service_id']);
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
