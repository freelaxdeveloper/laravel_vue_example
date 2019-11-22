<?php

use Illuminate\Database\Seeder;

use App\Models\Transaction;
use App\User;

class Transactions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $user = User::inRandomOrder()->where('id', '!=', 19)->first();
        Transaction::create([
            'user_id' => '19',
            'who_id' => $user->id,
            'amount' => mt_rand(100, 999),
            'platform' => 1 == mt_rand(0, 1) ? 'paypal' : 'ripple',
            'message' => $faker->city,
            'created_at' => 2018 . $faker->dateTimeThisCentury->format('-m-d H:i:s')
        ]);
    }
}
