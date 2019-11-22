<?php

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingPushDonate extends Seeder
{
    /**
     * Run the database seeds.
     * composer dump-autoload
     * php artisan db:seed --class=SettingPushDonate
     *
     * @return void
     */
    public function run()
    {
        Setting::whereName('PushDonate')->delete();

        $set = new Setting;
        $set->name = 'PushDonate';
        $settings = config('settings_default.pushDonate');
        $set->settings = $settings;
        $set->save();
    }
}
