<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class FriendController extends Controller
{
    public function index() {
        $user = \Auth::user();
        $friends = $user->friends()->get();
        $requests__from = $user->requests__from;
        $requests__to = $user->requests__to;
        $not_friend_users = User::all()
                                ->except($user->id)
                                ->except($user->friendships__to->modelKeys())
                                ->except($user->friendships__from->modelKeys());
        
        return view('friends.index', [
            'friends' => $friends,
            'requests__from' => $requests__from,
            'requests__to' => $requests__to,
            'not_friend_users' => $not_friend_users,
        ]);
    }
    
    public function add(Request $request) {
        $request->validate([
            'friends' => ['required', 'array'],
        ]);
        
        foreach ($request->friends as $str_id) {
            \Auth::user()->send_request_to((int) $str_id);
        }
        
        return back();
    }
    
    public function accept(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
        ]);
        $validator->validate();
        
        $result = \Auth::user()->accept_request_from($request->user_id);
        
        if (! $result) {
            $validator->errors()->add('user_id', '承認に失敗しました');
            return back()->withErrors($validator)->withInput();
        }
        
        return back();
    }
    
    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
        ]);
        $validator->validate();
        
        $result = \Auth::user()->delete_friendship($request->user_id);
        
        if (! $result) {
            $validator->errors()->add('user_id', '削除に失敗しました');
            return back()->withErrors($validator)->withInput();
        }
        
        return back();
    }
}
