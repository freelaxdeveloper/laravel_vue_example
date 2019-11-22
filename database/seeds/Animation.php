<?php

use Illuminate\Database\Seeder;
use App\Models\Animation as MAnimation;

class Animation extends Seeder
{
    /**
     * Run the database seeds.
     * composer dump-autoload
     * php artisan db:seed --class=Animation
     *
     * @return void
     */
    public function run()
    {
        $animations = [
            ['animate' => 'bounce'], ['animate' => 'flash'], 
            ['animate' => 'pulse'],  ['animate' => 'shake'], 
            ['animate' => 'jello'],  ['animate' => 'headShake'], 
            ['animate' => 'swing'],  ['animate' => 'tada'], 
            ['animate' => 'wobble'],
        ];

        MAnimation::insert($animations);
    }
}
