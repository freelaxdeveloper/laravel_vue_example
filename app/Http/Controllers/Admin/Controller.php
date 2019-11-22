<?php

namespace App\Http\Controllers\Admin;

use Config;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller AS BaseController;

class Controller extends BaseController
{

    public function __construct(Request $request)
    {
        Config::set('auth.providers.users.model', Admin::class);
    }
}
