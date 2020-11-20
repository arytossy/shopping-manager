<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class OrderController extends Controller
{
    public function add(Request $request) {
        $item = Item::findOrFail($request->item_id);
        
        $item->add_order_by(\Auth::id(), $request->required_number);
        
        return back();
    }
    
    public function change(Request $request) {
        $item = Item::findOrFail($request->item_id);
        
        $item->change_required_number($request->required_number, \Auth::id());
        
        return back();
    }
    
    public function destroy(Request $request) {
        $item = Item::findOrFail($request->item_id);
        
        $item->cancel_order_by(\Auth::id());
        
        return back();
    }
}
