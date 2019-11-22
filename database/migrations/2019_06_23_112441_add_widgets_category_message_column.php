<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\{WidgetCategory, Widget};

class AddWidgetsCategoryMessageColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Widget::truncate();
        WidgetCategory::whereNotNull('id')->delete();

        Schema::table('widget_categories', function (Blueprint $table) {
            $table->string('message')->after('title')->nullale();
            $table->string('slug')->after('title')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('widget_categories', function (Blueprint $table) {
            $table->dropColumn(['message', 'slug']);
        });
    }
}
