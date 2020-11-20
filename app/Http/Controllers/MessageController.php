<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
    public function store(Request $request) {
        \Auth::user()->messages()->create([
            'content' => $request->content,
            'thread_id' => $request->thread_id,
        ]);
        
        return back();
    }
    
    public function destroy($id) {
        $message = Message::findOrFail($id);
        $message->delete();
        
        return back();
    }
}
