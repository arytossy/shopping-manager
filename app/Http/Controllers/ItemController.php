<?php

namespace App\Http\Controllers;

use App\Events\ItemUpdated;
use App\Events\ThreadUpdated;
use App\Http\Resources\Item as ItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Item;
use App\Rules\HasCurrentUser;
use App\Thread;

class ItemController extends Controller
{
    /**
     * アイテム一覧取得
     * @return JSON
     */
    public function index(Request $request) {
        $request->validate([
            'thread_id' => ['required', new HasCurrentUser],
        ]);

        $items = Thread::find($request->thread_id)->items;

        return ItemResource::collection($items);
    }

    public function store(Request $request) {
        Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'thread_id' => ['required', new HasCurrentUser],
            'required_number' => ['required', 'numeric', 'min:1', 'max:10000'],
        ], [] ,[
            'name' => '品名',
        ])
        ->validate();
        
        $new_item = \Auth::user()->items()->create([
            'name' => $request->name,
            'is_shared' => $request->is_shared ? true : false,
            'bought_number' => 0,
            'thread_id' => $request->thread_id,
        ],[
            'required_number' => $request->required_number,
        ]);

        event(new ThreadUpdated($new_item->thread));
        
        return back();
    }
    
    public function update($id, Request $request) {
        $item = Item::findOrfail($id);

        if (! \Auth::user()->belong_to($item->thread->id)) {
            abort(404);
        }

        $request->validate([
            'bought_number' => ['required', 'numeric', 'min:0', 'max:100000'],
        ]);
        
        $item->bought_number = $request->bought_number;
        $item->save();

        event(new ThreadUpdated($item->thread));
        event(new ItemUpdated($item));
        
        return $item;
    }
    
    public function destroy($id) {
        $item = Item::findOrfail($id);
        
        if (! \Auth::user()->belong_to($item->thread->id)
                || ! $item->is_shared) {
            abort(404);
        }
        
        $item->delete();

        event(new ThreadUpdated($item->thread));
        
        return back();
    }
}
