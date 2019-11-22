<?php

use Illuminate\Database\Seeder;

use App\Models\Setting;

class SettingDonateForm extends Seeder
{
    /**
     * Run the database seeds.
     * composer dump-autoload
     * php artisan db:seed --class=SettingDonateForm
     *
     * @return void
     */
    public function run()
    {
        Setting::whereName('DonateForm')->delete();

        $set = new Setting;
        $set->name = 'DonateForm';
        $settings = config('settings_default.DonateForm');
        $set->settings = $settings;
        $set->save();
    }
}
