<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit');
    }
    
    public function update(Request $request) {
        $request->validate([
            'name' => 'required | max:255',
            'email' => 'required | max:255',
        ]);
        
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        
        return redirect('/');
    }
}
