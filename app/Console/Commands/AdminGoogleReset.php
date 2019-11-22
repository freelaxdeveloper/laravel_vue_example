<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Helper;
use App\Admin;
use Validator;

class AdminGoogleReset extends Command
{
    use Helper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AdminGoogleReset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сброс Google2fa для админ-профиля';

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
        $profile['email'] = $this->ask('Email');

        $validator = Validator::make($profile, [
            'email' => 'required|string|email|max:255|exists:admins',
        ]);
        if ($this->showErrors($validator)) {
            return;
        }

        $admin = Admin::whereEmail($profile['email'])->first();
        $admin->google2fa_secret = $admin->google2fa_code = null;

        if ($admin->save()) {
            return $this->info('Google2fa успешно сброшен');
        }
        
        return $this->error('Ошибка при сохранеии профиля');
    }
}
