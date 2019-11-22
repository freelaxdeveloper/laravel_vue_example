<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\WidgetCategory;

class CreateWidgetCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->timestamps();
        });

        $categories = [
          ['title' => 'Последнее сообщение'],
          ['title' => 'Самый крупный донатер'],
          ['title' => 'Последний донатер'],
          ['title' => 'Последний подписчик'],
          ['title' => 'Количество подписчиков за период'],
        ];

        WidgetCategory::insert($categories);

        Schema::table('widgets', function (Blueprint $table) {
            $table->dropColumn(['name']);
            $table->unsignedInteger('widget_category_id')->nullable()->after('user_id');

            $table->foreign('widget_category_id')->references('id')->on('widget_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widgets', function (Blueprint $table) {
            $table->dropForeign(['widget_category_id']);
        });

        Schema::table('widgets', function (Blueprint $table) {
            $table->dropColumn(['widget_category_id']);
            $table->string('name')->nullable();
        });

        Schema::dropIfExists('widget_categories');
    }
}
