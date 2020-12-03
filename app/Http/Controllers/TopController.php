<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function __invoke()
    {
        if (\Auth::check()) {
            return redirect()->route('threads.index');
        } else {
            return view('welcome');
        }
    }
}
