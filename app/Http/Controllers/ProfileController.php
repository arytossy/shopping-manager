<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit');
    }
    
    public function update(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(\Auth::id())],
        ], [
            'name.required' => 'ユーザー名は必須です',
            'name.max' => 'ユーザー名が長すぎます',
            'email.required' => 'メールアドレスは必須です',
            'email.email' => 'メールアドレスの書式が不正です',
            'email.max' => 'メールアドレスが長すぎます',
            'email.unique' => '既に使用されているメールアドレスです',
        ])->validate();
        
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        return redirect('/');
    }
}
