<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function store(Request $request) {
        \Auth::user()->items()->create([
            'name' => $request->name,
            'is_shared' => $request->is_shared ? true : false,
            'bought_number' => 0,
            'thread_id' => $request->thread_id,
        ],[
            'required_number' => $request->required_number,
        ]);
        
        return back();
    }
    
    public function update($id, Request $request) {
        $item = Item::findOrfail($id);
        $item->bought_number = $request->bought_number;
        
        $item->save();
        
        return back();
    }
    
    public function destroy($id) {
        
    }
}
