<?php

use Illuminate\Database\Seeder;

use App\Models\Badge;

class BadgeGenerate extends Seeder
{
    /**
     * Run the database seeds.
     * composer dump-autoload
     * php artisan db:seed --class=BadgeGenerate
     *
     * @return void
     */
    public function run()
    {
        $badges = [];
        $files = glob(public_path('img/badges') . '/*');
        
        for ($i = 0; $i < count($files); $i++) {
            $path = $files[$i];
            $name = basename($path, '.png');
            $size = getimagesize($path);
            $size = "{$size[0]}x{$size[1]}";

            $badges[] = compact('path', 'name', 'size');
        }
        Badge::whereNotNull('id')->delete();
        Badge::insert($badges);
    }
}
