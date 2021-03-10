<?php

namespace App\Http\Controllers;

use App\Events\MessageAdded;
use App\Events\MessageDeleted;
use App\Events\ThreadUpdated;
use App\Message;
use App\Rules\HasCurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    /**
     * @return json
     */
    public function index(Request $request) {
        $request->validate([
            'thread_id' => ['required', new HasCurrentUser],
        ]);

        $messages = Message::where('thread_id', $request->thread_id)
                                ->orderBy('id', 'asc')
                                ->get();
        return $messages;
    }

    /**
     * @return json
     */
    public function store(Request $request) {
        $request->validate([
            'content' => ['required', 'max:255'],
            'thread_id' => ['required', new HasCurrentUser],
        ]);

        $new_message = \Auth::user()->messages()->create([
            'content' => $request->content,
            'thread_id' => $request->thread_id,
        ])
        ->load('user');

        event(new ThreadUpdated($new_message->thread));
        event(new MessageAdded($new_message));

        return $new_message;
    }
    
    public function destroy($id) {
        $message = \Auth::user()->messages()->findOrFail($id);
        
        $message->delete();

        event(new ThreadUpdated($message->thread));
        event(new MessageDeleted($message));
        
        return null;
    }
}
