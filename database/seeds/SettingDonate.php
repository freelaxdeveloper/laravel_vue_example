<?php

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingDonate extends Seeder
{
    /**
     * Run the database seeds.
     * composer dump-autoload
     * php artisan db:seed --class=SettingDonate
     *
     * @return void
     */
    public function run()
    {
        Setting::whereName('Donate')->delete();

        $set = new Setting;
        $set->name = 'Donate';
        $settings = config('settings_default.Donate');
        $set->settings = $settings;
        $set->save();
    }
}
