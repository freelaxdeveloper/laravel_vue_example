<?php
namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Command;
use App\Console\Helper;
use App\Admin;
use Validator;

class AdminCreate extends Command
{
    use Helper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AdminCreate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание профиля администратора';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment($this->description);

        $profile = [];
        $profile['name'] = $this->ask('Имя');
        $profile['email'] = $this->ask('Email');
        $profile['password'] = $this->secret('Пароль');
        $profile['password_confirmation'] = $this->secret('Повторите пароль');

        $validator = Validator::make($profile, [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($this->showErrors($validator)) {
            return;
        }

        $user = Admin::create([
            'name' => $profile['name'],
            'email' => $profile['email'],
            'password' => Hash::make($profile['password']),
            'roles' => ['admin'],
        ]);

        $this->info("Профиль \"{$profile['email']}\" успешно создан");
    }
}
