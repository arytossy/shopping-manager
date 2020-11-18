<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        
    }
    
    public function show($id) {
        
    }
    
    public function update($id, Request $request) {
        
    }
}
