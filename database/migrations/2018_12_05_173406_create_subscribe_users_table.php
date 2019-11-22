<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('user_id')->comment('Чей это подписчик');
            $table->enum('free', [0, 1])->nullable()->comment('Простая подписка');
            $table->enum('paid', [1000, 2000, 3000])->nullable()->comment('Платная подписка');
            $table->dateTime('premium')->nullable()->comment('Премиум подписка');
            $table->unsignedInteger('subscribers_id')->comment('ID анкеты подписчика');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subscribers_id')->references('id')->on('subscribers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers_user');
    }
}
