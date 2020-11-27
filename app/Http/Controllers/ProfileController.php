<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use JD\Cloudder\Facades\Cloudder;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit');
    }
    
    public function update(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(\Auth::id())],
            'avatar' => ['nullable', 'image'],
        ])->validate();
        
        $user = \Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->is_default) {
            
            $user->avatar = '/images/default-avatar.png';
            
            if ($user->public_id) {
                Cloudder::delete($user->public_id);
                $user->public_id = null;
            }
            
        } else {
            
            if ($file = $request->file('avatar')) {
                
                $file_path = $file->getRealPath();
                Cloudder::upload($file_path, null, ['folder' => 'shopping_manager']);
                $public_id = Cloudder::getPublicId();
                $avatar_url = Cloudder::secureShow($public_id, [
                    'width' => 100,
                    'height' => 100,
                    'crop' => 'fill',
                    'gravity' => 'auto',
                ]);
                
                if ($user->public_id) {
                    Cloudder::delete($user->public_id);
                }
                
                $user->avatar = $avatar_url;
                $user->public_id = $public_id;
            }
        }
        
        $user->save();
        
        return redirect('/');
    }
}
