<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ThreadController extends Controller
{
    public function index() {
        $threads = \Auth::user()->threads;
        return view('threads.index', [
            'threads' => $threads,
        ]);
    }
    
    public function create() {
        $friends = \Auth::user()->friends()->get();
        return view('threads.create', [
            'friends' => $friends,
        ]);
    }
    
    public function store(Request $request) {
        $new_thread = Thread::create([
            'title' => $request->title,
            'where_go' => $request->where_go,
            'when_go' => $request->when_go,
        ]);
        
        foreach ($request->members as $val) {
            $thread_member_ids[] = (int) $val;
        }
        $thread_member_ids[] = \Auth::id();
        $new_thread->add_members($thread_member_ids);
        
        return redirect()->route('threads.show', ['thread' => $new_thread->id]);
    }
    
    public function show($id) {
        $thread = Thread::findOrFail($id);
        $items = $thread->items;
        $members = $thread->members;
        $messages = $thread->messages;
        $friends = \Auth::user()->friends()->get();
        
        return view('threads.show', [
            'thread' => $thread,
            'items' => $items,
            'members' => $members,
            'messages' => $messages,
            'friends' => $friends,
        ]);
    }
    
    public function update($id, Request $request) {
        $thread = Thread::findOrFail($id);
        $thread->title = $request->title;
        $thread->where_go = $request->where_go;
        $thread->when_go = $request->when_go;
        
        $thread->save();
        
        return back();
    }
}
