<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\{Admin, User};
use JWTAuth;

class UserController extends Controller
{

    public function info()
    {
        $user = JWTAuth::parseToken()->toUser();

        return $this->success($user);
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required|integer|exists:users',
            'name' => 'required|string',
            'status' => 'required|string',
            'is_vk' => 'nullable',
        ])->validate();

        $profile = $request->only(['name', 'is_vk']);
        $profile['is_vk'] = $profile['is_vk'] ? 1 : 0;

        $user = User::withTrashed()->find($request->id);
        $user->update($profile);

        if ($request->status != $user->status) {
            $user->updateStatus($request->status);
        }

        return $this->success('Success');
    }

    public function updateStatus(Request $request)
    {
        Validator::make($request->all(), [
            'status' => 'required|in:draft,published,deleted',
            'user_id' => 'integer|exists:users,id'
        ])->validate();

        $user = User::withTrashed()->find($request->user_id);
        if ($user->status != $request->status) {
            $user->updateStatus($request->status);
        }

        return $this->success($request->all());
    }

    public function list()
    {
        $users = User::withTrashed()->get();
        return $this->success([
            'items' => $users,
            'total' => $users->count()
        ]);
    }
}
