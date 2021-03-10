<?php

namespace App\Http\Controllers;

use App\Events\ThreadUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Item;

class OrderController extends Controller
{
    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'item_id' => ['required'],
            'required_number' => ['required', 'numeric', 'min:1', 'max:10000'],
        ]);
        $validator->validate();
        
        $item = Item::find($request->item_id);
        
        if (! $item 
                || ! \Auth::user()->belong_to($item->thread->id)
                || $item->is_shared) {
            $validator->errors()->add('item_id', '対象品目が不正です');
            return back()->withErrors($validator)->withInput();
        }
        
        $result = $item->add_order_by(\Auth::id(), $request->required_number);
        
        if (! $result) {
            $validator->errors()->add('user', '既に頼んでいます');
            return back()->withErrors($validator)->withInput();
        }

        event(new ThreadUpdated($item->thread));
        
        return back();
    }
    
    public function change(Request $request) {
        $validator = Validator::make($request->all(), [
            'item_id' => ['required'],
            'required_number' => ['required', 'numeric', 'min:1', 'max:10000'],
        ]);
        $validator->validate();
        
        $item = Item::find($request->item_id);
        
        if (! $item 
                || ! \Auth::user()->belong_to($item->thread->id)) {
            $validator->errors()->add('item_id', '対象品目が不正です');
            return back()->withErrors($validator)->withInput();
        }
        
        $result = $item->change_required_number($request->required_number, \Auth::id());
        
        if (! $result) {
            $validator->errors()->add('item_id', '対象品目が不正です');
            return back()->withErrors($validator)->withInput();
        }

        event(new ThreadUpdated($item->thread));
        
        return back();
    }
    
    public function destroy(Request $request) {
        $validator = Validator::make($request->all(), [
            'item_id' => ['required'],
        ]);
        $validator->validate();
        
        $item = Item::find($request->item_id);
        
        if (! $item 
                || ! \Auth::user()->belong_to($item->thread->id)) {
            $validator->errors()->add('item_id', '対象品目が不正です');
            return back()->withErrors($validator)->withInput();
        }
        
        $result = $item->cancel_order_by(\Auth::id());
        
        if (! $result) {
            $validator->errors()->add('item_id', 'そもそも頼んでいません');
            return back()->withErrors($validator)->withInput();
        }

        event(new ThreadUpdated($item->thread));
        
        return back();
    }
}
