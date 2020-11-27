<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Item;

class ItemController extends Controller
{
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'thread_id' => ['required'],
            'required_number' => ['required', 'numeric', 'min:1', 'max:10000'],
        ], [] ,[
            'name' => '品名',
        ]);
        $validator->validate();
        
        if (! \Auth::user()->belong_to($request->thread_id)) {
            $validator->errors()->add('thread_id', '対象スレッドが不正です');
            return back()->withErrors($validator)->withInput();
        }
        
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
            'bought_number' => 'required | numeric | min:0 | max:100000',
        ]);
        
        $item = Item::findOrfail($id);
        
        if (! \Auth::user()->belong_to($item->thread->id)) {
            abort(404);
        }
        
        $item->bought_number = $request->bought_number;
        $item->save();
        
        return back();
    }
    
    public function destroy($id) {
        $item = Item::findOrfail($id);
        
        if (! \Auth::user()->belong_to($item->thread->id)
                || ! $item->is_shared) {
            abort(404);
        }
        
        $item->delete();
        
        return back();
    }
}
