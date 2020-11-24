<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required | max:255',
            'thread_id' => 'required',
            'required_number' => 'required | numeric'
        ]);
        
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
        $request->validate([
            'bought_number' => 'required | numeric | min:0',
        ]);
        
        $item = Item::findOrfail($id);
        $item->bought_number = $request->bought_number;
        
        $item->save();
        
        return back();
    }
    
    public function destroy($id) {
        $item = Item::findOrfail($id);
        $item->delete();
        
        return back();
    }
}
