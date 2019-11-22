<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Admin;
use JWTAuth;

class TransactionController extends Controller
{
    // public function __construct()
    // {
    //     \Config::set('auth.providers.users.model', \App\Admin::class);
    // }

    public function list()
    {
        return $this->success(['TransactionController']);
    }

}
