<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    public function users_search(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->get('email')];
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || $user->id == \Auth::id()) {
            return null;
        }

        $result = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'exists_friendship' => $user->exists_friendship(\Auth::id()),
        ];

        return $result;
    }
}
