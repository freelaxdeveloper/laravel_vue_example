<?php

use Illuminate\Database\Seeder;

use App\Models\WidgetCategory;

class WidgetsCategory extends Seeder
{
    /**
     * Run the database seeds.
     * composer dump-autoload
     * php artisan db:seed --class=WidgetsCategory
     *
     * @return void
     */
    public function run()
    {
        WidgetCategory::whereNotNull('id')->delete();

        $items = [
            [
                'title' => 'Последнее сообщение', 
                'message' => 'Последнее сообщение: {{message}}',
                'slug' => WidgetCategory::slugGenerate(),
            ],
            [
                'title' => 'Самый крупный донатер', 
                'message' => 'Самый(-е) крупный(-е) донатер(-ы): {{users}} || {{name}} {{sum}}',
                'slug' => WidgetCategory::slugGenerate(),
            ],
            [
                'title' => 'Последний донатер', 
                'message' => 'Последний(-е) донатер(-ы): {{users}} || {{name}} {{sum}}',
                'slug' => WidgetCategory::slugGenerate(),
            ],
            [
                'title' => 'Последний подписчик', 
                'message' => 'Последний(-е) подписчик(-и): {{subscriber}}',
                'slug' => WidgetCategory::slugGenerate(),
            ],
            [
                'title' => 'Количество подписчиков за период', 
                'message' => 'Количество подписчиков за период: {{count}} {{type}} {{period}}',
                'slug' => WidgetCategory::slugGenerate(),
            ],
            
            [
                'title' => 'Сбор средств', 
                'message' => 'Сбор средств - 1',
                'slug' => WidgetCategory::slugGenerate(),
            ],
        ];

        WidgetCategory::insert($items);
    }
}
