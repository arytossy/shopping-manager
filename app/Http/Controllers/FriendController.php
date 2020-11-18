<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index() {
        $user = \Auth::user();
        $friends = $user->friends()->get();
        $requests__from = $user->requests__from;
        $requests__to = $user->requests__to;
        return view('friends.index', [
            'friends' => $friends,
            'requests__from' => $requests__from,
            'requests__to' => $requests__to,
        ]);
    }
    
    public function add(Request $request) {
        
    }
    
    public function accept(Request $request) {
        
    }
    
    public function destroy(Request $request) {
        
    }
}
